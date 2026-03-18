<?php
/**
 * Media Manager Element
 *
 * @var $mediaModel: If not provided it will be acquired from the params->controller
 *
 * @var $mediaId: If available id of the object, otherwise will not be asyncrhous the upload
 *
 * @var $mediaCollection: Name of the specific collection for the object. Default 'main'.
 *
 * @var $mediaPrivate: Allow if media can be acceced in the library. Default FALSE
 *
 * @var $mediaMultiple: Allow if multiple files can be uploaded. Default TRUE
 *
 * @var $mediaIcons: Define icons of media supported.
 *
 * @var $mediaExtensions: Define types of media files supported. Default *ALL*
 *
 * @var $mediaServices: Define types of media services supported. Default *ALL*
 *
 */

if (empty($mediaLibrary)) {
	$this->Package->append('view', 'js', array(
		'vendor.dropzone.dropzone',
		'widget.media-manager'
	));

	$this->Package->append('view', 'css', array(
		'admin.widget.media-manager'
	));
}

$from = isset($from) ? $from : null;

$dataAttributes = '';
$dataAttributes .= !empty($mediaCollection) ? " data-collection='" . $mediaCollection . "'" : "";
$dataAttributes .= !empty($mediaPrivate) ? " data-private='1'" : "";
$dataAttributes .= empty($mediaMultiple) ? " data-multiple='0'" : "";
$dataAttributes .= empty($mediaMultiple) ? "" : " data-sortable-container";
$dataAttributes .= " data-drop='" . (empty($mediaFormats) || !empty($viewOnly) ? 0 : 1) . "'";
$dataAttributes .= " data-name='" . $mediaName . "'";
$dataAttributes .= " data-field='data[" . $mediaField . "]'";

if (!empty($mediaExtensions)) {
	$dataAttributes .= " data-extensions='" . implode(',', $mediaExtensions) . "'";
}

if (!empty($mediaServices)) {
	$dataAttributes .= " data-services='" . implode(',', $mediaServices) . "'";
}

if (!empty($mediaMaxSize)) {
	$dataAttributes .= " data-size='" . $mediaMaxSize . "'";
	$dataAttributes .= " data-readable-size='" . CakeNumber::toReadableSize($mediaMaxSize * 1024 * 1024) . "'";
}

if (!empty($viewOnly)) {
	$dataAttributes .= " data-view-only='1'";
}
?>

<?php if (!empty($mediaFormats)) : ?>
	<script>
		window.hozen.config.media = window.hozen.config.media || {};
		window.hozen.config.media["<?php echo $mediaName ?>"] = <?php echo $this->Js->object($mediaFormats) ?>;
	</script>
<?php endif ?>

<div id='Media<?php echo Inflector::camelize($mediaCollection) ?>' class='media-dropzone<?php echo empty($mediaMultiple) ? ' media-single' : ' media-multiple' ?>'>
	<?php if (!empty($mediaLabel)) : ?>
		<?php $labelKey = $mediaLabel === TRUE ? $mediaCollection : $mediaLabel ?>
		<div class="media-title"><?php echo Utility::translate(Utility::slug($labelKey), Inflector::underscore($mediaModel), 'fields') ?></div>
	<?php endif ?>

	<div class='d-flex flex-wrap media-items boxes<?php echo empty($mediaFormats) ? '' : ' media-drop' ?>' data-media <?php echo $dataAttributes ?>>
		<?php
		if (isset($mediaData)) {
			$modelData = $mediaData;
		} else {
			$modelData = Inflector::variable($mediaModel);
			$modelData = empty($$modelData) ? NULL : $$modelData;
		}

		echo $this->element('admin/widgets/media/drop', array('mediaTypes' => $mediaTypes, 'mediaExtensions' => $mediaExtensions, 'mediaMaxSize' => $mediaMaxSize, 'viewOnly' => !empty($viewOnly), 'mediaLibrary' => !empty($mediaLibrary)));

		if (!empty($modelData[$mediaField]) && (!empty($mediaMultiple) || !empty($modelData[$mediaField]['id']))) {
			$mediaItems = !empty($mediaMultiple) ? $modelData[$mediaField] : array($modelData[$mediaField]);

			foreach ($mediaItems as $mediaItem) {
				echo $this->element('admin/widgets/media/item', array(
					'mediaAttributes' => $mediaAttributes,
					'mediaItem' => $mediaItem,
					'mediaPath' => $mediaPath,
					'mediaUrl' => $mediaUrl,
					'mediaMultiple' => $mediaMultiple,
					'mediaNotEmpty' => !empty($mediaNotEmpty),
					'mediaLibrary' => !empty($mediaLibrary),
					'mediaPreview' => !empty($mediaPreview) ? $mediaPreview : false,
					'viewOnly' => !empty($viewOnly),
					'from' => $from
				));
			}
		}
		?>
	</div>
</div>

<?php
if (!empty($mediaPreview) && empty($setMediaPreviewModal)) {
	$this->Package->append('view', 'js', array(
		'widget.form'
	));

	$this->append('modals');
		echo $this->element('admin/widgets/media/preview');
		echo $this->element('admin/widgets/media/share');
		echo $this->element('admin/widgets/media/attribute');
	$this->end();
	$this->set('setMediaPreviewModal', true);
}
?>
