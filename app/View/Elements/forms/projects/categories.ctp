<?php
$selectedIds = array();
if (!empty($this->request->data['Category']['Category'])) {
    $selectedIds = $this->request->data['Category']['Category'];
} elseif (!empty($project['Category'])) {
    foreach ($project['Category'] as $cat) {
        $selectedIds[] = $cat['id'];
    }
}
?>
<div class="input form-group project-categories">
    <label class="control-label"><?= __('Categorías') ?></label>
    <input type="hidden" name="data[Category][Category]" value="">
    <div class="categories-checkboxes">
        <?php if (!empty($categories)) : ?>
            <?php foreach ($categories as $catId => $catName) : ?>
                <div class="checkbox">
                    <input type="checkbox"
                           id="cat_<?= $catId ?>"
                           name="data[Category][Category][]"
                           value="<?= $catId ?>"
                           <?= in_array($catId, $selectedIds) ? 'checked' : '' ?>>
                    <label for="cat_<?= $catId ?>"><?= h($catName) ?></label>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-muted">No hay categorías disponibles.</p>
        <?php endif; ?>
    </div>
</div>
