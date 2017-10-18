<?php
if (!isset($editable)) {
    $editable = ' editable';
} else {
    if (empty($editable)) {
        $editable = '';
    } else {
        $editable = ' editable';
    }
}
if (empty($value)) {
    $value = 0;
}
if (!isset($label)) {
    $label = false;
}
if (!isset($id)) {
    $id = 'idOfStars' . rand(0, 100000);
}

$label_class = '';
if($label) {
    $label_class = ' with-label';
}
$max_value = 10;
?>
<div class="rating<?php echo $editable ?><?php echo $label_class; ?>">
    <?php
    if (!empty($name)) {
        echo $this->form->input('hidden', array('type' => 'hidden', 'name' => $name, 'value' => $value, 'id' => $id));
    }
    ?>
    <div class="slider">
        <div class="stars">
            <?php for ($i = 0; $i < $max_value; $i++) : ?>
                <?php
                if ($i % 2) {
                    $class = 'right';
                } else {
                    $class = 'left';
                }
                if ($i / 2 < $value) {
                    $class .= ' selected';
                }
                ?>
                <?php if (!($i % 2)) : ?>
                    <div class="star">
                    <?php endif; ?>
                    <div class="mid <?php echo $class; ?>" data-value="<?php echo ($i + 1) / 2; ?>"></div>
                    <?php if ($i % 2) : ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
        <div class="listeners">
            <?php for ($i = 0; $i < $max_value + 1; $i++) : ?>
                <?php
                if ($i % 2) {
                    $class = 'right';
                } else {
                    $class = 'left';
                }
                ?>
                <div class="listener" data-value="<?php echo $i / 2; ?>"></div>
            <?php endfor; ?>
        </div>
    </div>
    <?php if($label) : ?>
        <center class="label-container">
            <div class="label">
                <?php //echo number_format($value, 1); ?>
            </div>
        </center>
    <?php endif; ?>
</div>
