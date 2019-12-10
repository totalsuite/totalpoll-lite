<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Above', 'totalpoll' ); ?>
            <span class="totalpoll-feature-details"
                  tooltip="<?php _e( 'This content will be shown above results.', 'totalpoll' ); ?>">?</span>
        </label>
        <progressive-textarea ng-model="editor.settings.content.results.above"></progressive-textarea>
    </div>
</div>
<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Below', 'totalpoll' ); ?>
            <span class="totalpoll-feature-details"
                  tooltip="<?php _e( 'This content will be shown below results.', 'totalpoll' ); ?>">?</span>
        </label>
        <progressive-textarea ng-model="editor.settings.content.results.below"></progressive-textarea>
    </div>
</div>