<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <?php if(! Auth::guest()): ?>
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo e(Gravatar::fallback(asset('la-assets/img/user2-160x160.jpg'))->get(Auth::user()->email)); ?>" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p><?php echo e(Auth::user()->name); ?></p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- search form (Optional) -->
        <?php if(LAConfigs::getByKey('sidebar_search')): ?>
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
	                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <?php endif; ?>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MODULES</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="<?php echo e(url(config('laraadmin.adminRoute'))); ?>"><i class='fa fa-home'></i> <span><?php echo app('translator')->getFromJson('validation.dashboard'); ?></span></a></li>
            <?php
            $menuItems = Dwij\Laraadmin\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
            ?>
            <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($menu->type == "module"): ?>
                    <?php
                    $temp_module_obj = Module::get($menu->name);
                    ?>
                    <?php if(LAFormMaker::la_access($temp_module_obj->id)) { ?>
						<?php if(isset($module->id) && $module->name == $menu->name): ?>
                        	<?php echo LAHelper::print_menu($menu ,true); ?>
						<?php else: ?>
							<?php echo LAHelper::print_menu($menu); ?>
						<?php endif; ?>
                    <?php } ?>
                <?php else: ?>
                    <?php echo LAHelper::print_menu($menu); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- LAMenus -->

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
