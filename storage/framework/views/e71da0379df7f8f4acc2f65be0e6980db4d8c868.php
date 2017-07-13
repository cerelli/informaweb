<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $__env->yieldContent('contentheader_title', 'Page Header here'); ?>
        <small><?php echo $__env->yieldContent('contentheader_description'); ?></small>
    </h1>
    <?php if (! empty(trim($__env->yieldContent('headerElems')))): ?>
        <span class="headerElems">
        <?php echo $__env->yieldContent('headerElems'); ?>
        </span>
    <?php else: ?> 
        <?php if (! empty(trim($__env->yieldContent('section')))): ?>
        <ol class="breadcrumb">
            <li><a href="<?php echo $__env->yieldContent('section_url'); ?>"><i class="fa fa-dashboard"></i> <?php echo $__env->yieldContent('section'); ?></a></li>
            <?php if (! empty(trim($__env->yieldContent('sub_section')))): ?><li class="active"> <?php echo $__env->yieldContent('sub_section'); ?> </li><?php endif; ?>
        </ol>
        <?php endif; ?>
    <?php endif; ?>
</section>