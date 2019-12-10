<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" ng-model="$ctrl.options.advanced.inlineCss">
			<?php _e( 'Always embed CSS with HTML.', 'totalpoll' ); ?>
        </label>

        <p class="totalpoll-feature-tip"><?php _e( "This option might be useful when WordPress isn't running on standard filesystem.", 'totalpoll' ); ?></p>
    </div>
</div>
<div class="totalpoll-settings-item totalpoll-pro-badge-container">
    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" disabled>
			<?php _e( 'Render full poll when listed in polls archive.', 'totalpoll' ); ?>
        </label>

        <p class="totalpoll-feature-tip"><?php _e( "This option will render all polls instead of showing titles only.", 'totalpoll' ); ?></p>
    </div>
    <?php TotalPoll( 'upgrade-to-pro' ); ?>
</div>
<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" ng-model="$ctrl.options.advanced.disableArchive">
			<?php _e( 'Disable polls archive.', 'totalpoll' ); ?>
        </label>
    </div>
</div>
<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" ng-model="$ctrl.options.advanced.uninstallAll">
			<?php _e( 'Remove all data on uninstall.', 'totalpoll' ); ?>
        </label>

        <p class="totalpoll-warning"><?php _e( "Heads up! This will remove all TotalPoll data including options, cache files and polls.", 'totalpoll' ); ?></p>
    </div>
</div>
