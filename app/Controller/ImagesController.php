<?php
App::uses('AppController', 'Controller');
class ImagesController extends AppController {

	public function beforeRender() {
		parent::beforeRender();

		if ($this->RequestHandler->ext == 'json') {
			if ($this->request->action == 'admin_upload') {
				$this->viewClass = 'Json';
			}
		}
	}

	public function admin_add($webPageElementId = null) {
		$this->loadModel('WebPageElement');
		$element = $this->WebPageElement->find('first', array(
			'conditions' => array('WebPageElement.id' => $webPageElementId),
			'contain' => array('MediaImage', 'WebPageSection' => array('WebPageTranslation' => array('WebPage')))
		));

		if (!$element) {
			$this->redirect(array('controller' => 'web_pages', 'action' => 'index'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->WebPageElement->save($this->request->data);
			$this->Flash->success(__('👍'));
			$this->redirect(array(
				'controller' => 'web_pages',
				'action' => 'view',
				$element['WebPageSection']['WebPageTranslation']['web_page_id'],
				Utility::slug($element['WebPageSection']['WebPageTranslation']['WebPage']['name']),
				'?' => array('lang' => $element['WebPageSection']['WebPageTranslation']['language'])
			));
		}
		if (!$this->request->data) {
			$this->request->data = $element;
		}

		$this->set(array(
			'webPageElement' => $element,
			'mediaConfig' => $this->WebPageElement->getMediaConfig(),
			'referer' => $this->referer()
		));
	}

	public function admin_upload() {
		$response = [];
		$fileKey = 'upload';
		// 5M
		$fileSizeLimit = 5 * 1024 * 1024;
		$fileDir = '/files/image';
		$fileHash = '';

		// See https://www.php.net/manual/en/features.file-upload.php#114004
		try {
			// Undefined | Multiple Files | $_FILES Corruption Attack
			// If this request falls under any of them, treat it invalid.
			if (
				!isset($_FILES[$fileKey]['error']) ||
				is_array($_FILES[$fileKey]['error'])
			) {
				throw new RuntimeException('Invalid parameters.');
			}

			// Check $_FILES[$fileKey]['error'] value.
			switch ($_FILES[$fileKey]['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Exceeded filesize limit.');
				default:
					throw new RuntimeException('Unknown errors.');
			}

			// You should also check filesize here.
			if ($_FILES[$fileKey]['size'] > $fileSizeLimit) {
				throw new RuntimeException(
					sprintf(
						'Exceeded filesize limit (%s).',
						CakeNumber::toReadableSize($fileSizeLimit)
					)
				);
			}

			// DO NOT TRUST $_FILES[$fileKey]['mime'] VALUE !!
			// Check MIME Type by yourself.
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			if (false === $ext = array_search(
				$finfo->file($_FILES[$fileKey]['tmp_name']),
				[
					'jpg' => 'image/jpeg',
					'png' => 'image/png',
					'gif' => 'image/gif'
				],
				true
			)) {
				throw new RuntimeException('Invalid file format.');
			}

			// You should name it uniquely.
			// DO NOT USE $_FILES[$fileKey]['name'] WITHOUT ANY VALIDATION !!
			// On this example, obtain safe unique name from its binary data.
			$fileHash = sha1_file($_FILES[$fileKey]['tmp_name']);
			$fileName = sprintf(
				'%s.%s',
				$fileHash,
				$ext
			);
			if (!move_uploaded_file(
				$_FILES[$fileKey]['tmp_name'],
				sprintf(
					WWW_ROOT . '%s/%s',
					str_replace('/', DS, $fileDir),
					$fileName
				)
			)) {
				throw new RuntimeException('Failed to move uploaded file.');
			}

			$response = [
				'uploaded' => 1,
				'fileName' => $fileName,
				'url' => sprintf(
					'%s/%s',
					$fileDir,
					$fileName
				)
			];
		} catch (RuntimeException $e) {
			$response = [
				'uploaded' => 0,
				'error' => [
					'message' => $e->getMessage()
				]
			];
		}

		$this->set($response);
		$this->set('_serialize', array_keys($response));
	}
}
?>
