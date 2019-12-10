<div id="totalpoll-modules" class="wrap totalpoll-page" ng-app="modules" ng-controller="ModulesCtrl as modules">
    <h1 class="totalpoll-page-title">
		<?php _e( 'Extensions', 'totalpoll' ); ?>
        <button type="button" ng-click="modules.toggleInstaller()" class="page-title-action" role="button"><span class="upload"><?php _e( 'Upload', 'totalpoll' ); ?></span></button>
    </h1>
    <modules-installer ng-if="modules.isInstallerVisible()"></modules-installer>
    <div class="totalpoll-page-tabs">
        <div class="totalpoll-page-tabs-item active" tab-switch="modules>installed">
			<?php _e( 'Installed', 'totalpoll' ); ?>
        </div>
        <div class="totalpoll-page-tabs-item" tab-switch="modules>store">
			<?php _e( 'Store', 'totalpoll' ); ?>
        </div>
        <div class="totalpoll-page-tabs-item right" ng-click="modules.refresh()">
            <span class="dashicons dashicons-update"></span>
			<?php _e( 'Refresh', 'totalpoll' ); ?>
        </div>
    </div>
    <modules-manager type="'extensions'"></modules-manager>

	<?php include __DIR__ . '/../../views/install.php'; ?>
	<?php include __DIR__ . '/../../views/manager.php'; ?>
</div>