<?php
$active = empty($active) ? "{$this->request->params['controller']}:{$this->request->params['action']}" : $active;
$menus = isset($menus) ? $menus : array();
?>
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <?php
        foreach ($menus as $text => $menu) : ?>
            <?php
            $class = $active == "{$menu['url']['controller']}:{$menu['url']['action']}" ? 'active' : '';
            ?>
            <li class="<?php echo $class; ?>">
                <!--                --><?php
                //                $textPlusIcon = empty($menu['icon']) ? '' : '<i class="fa fa-fw fa-' . $menu['icon'] . '"></i>';
                //                $textPlusIcon .= '<div class="text">';
                //                $textPlusIcon .= '<div class="title">' . $text . '</div>';
                //                $textPlusIcon .= empty($menu['info']) ? '' : '<p class="info">' . $menu['info'] . '</p>';
                //                $textPlusIcon .= '</div>';
                //                echo $this->Html->link($textPlusIcon, $menu['url'], $options);
                //                ?>
                <a href="<?php echo Router::url($menu['url']); ?>">
                    <?php if (!empty($menu['icon'])): ?>
                        <i class="fa fa-fw fa-<?php echo $menu['icon']; ?>"></i>
                    <?php endif ?>
                    <div class="text">
                        <div class="title">
                            <?php echo $text; ?>
                        </div>
                        <?php if (!empty($menu['info'])): ?>
                            <p class="info">
                                <?php echo $menu['info']; ?>
                            </p>
                        <?php endif ?>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</nav>