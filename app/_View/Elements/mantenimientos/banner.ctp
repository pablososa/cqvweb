<?php if (!empty($mantenimientos)) : ?>
    <div class="mantenimiento alert alert-warning pt15">
        <?php foreach ($mantenimientos as $mantenimiento) : ?>
            <div>
                <?php echo $mantenimiento['Mantenimiento']['mensaje']; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>