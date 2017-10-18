<div class="row text-center">
    <div class="col-xs-12">
        <ul class='pagination'>
            <li><?php echo $this->Paginator->prev('<<'); ?></li>
            <?php echo $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'separator' => '')); ?>
            <li><?php echo $this->Paginator->next('>>'); ?></li>
        </ul>
    </div>
</div>