<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <div class="button-group">
            <a href="<?php echo esc_attr( admin_url( 'import.php?import=wordpress' ) ); ?>" class="button">
				<?php _e( 'Import data', 'totalpoll' ); ?>
            </a>
            <a href="<?php echo esc_attr( admin_url( 'export.php?content=poll&download' ) ); ?>" class="button">
				<?php _e( 'Export data', 'totalpoll' ); ?>
            </a>
            <button type="button" class="button" ng-click="$ctrl.downloadSettings()">
				<?php _e( 'Export settings', 'totalpoll' ); ?>
            </button>
        </div>
        <p class="totalpoll-feature-tip">
			<?php _e( 'TotalPoll uses standard WordPress import/export mechanism.', 'totalpoll' ); ?>
        </p>
    </div>
</div>
<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <textarea class="widefat" name="" rows="10" placeholder="<?php esc_attr_e( 'Drag and drop settings file or copy then paste its content here.', 'totalpoll' ); ?>" ng-model="$ctrl.import.content" ng-disabled="$ctrl.isImporting()"></textarea>
    </div>
    <div class="totalpoll-settings-field">
        <button type="button" class="button" ng-click="$ctrl.importSettings()" ng-disabled="!$ctrl.isImportReady()">
            <span ng-if="!$ctrl.isImporting() && !$ctrl.isImported()"><?php _e( 'Import settings', 'totalpoll' ); ?></span>
            <span ng-if="$ctrl.isImporting()"><?php _e( 'Importing', 'totalpoll' ); ?></span>
            <span ng-if="$ctrl.isImported()"><?php _e( 'Imported', 'totalpoll' ); ?></span>
        </button>
    </div>
</div>