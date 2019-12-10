<div class="totalpoll-settings-item totalpoll-pro-badge-container">
    <p class="totalpoll-feature-tip" ng-non-bindable><?php _e( 'Poll title: {{title}}', 'totalpoll' ); ?></p>
    <p class="totalpoll-feature-tip" ng-non-bindable><?php _e( 'Choices: {{choices}}', 'totalpoll' ); ?></p>
    <p class="totalpoll-feature-tip" ng-non-bindable><?php _e( 'User IP: {{ip}}', 'totalpoll' ); ?></p>
    <p class="totalpoll-feature-tip" ng-non-bindable><?php _e( 'User browser: {{browser}}', 'totalpoll' ); ?></p>
    <p class="totalpoll-feature-tip" ng-non-bindable><?php _e( 'Vote date: {{date}}', 'totalpoll' ); ?></p>

    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Title', 'totalpoll' ); ?>
        </label>
        <input type="text" class="totalpoll-settings-field-input widefat" disabled>
    </div>
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Plain text body', 'totalpoll' ); ?>
        </label>
        <textarea type="text" class="totalpoll-settings-field-input widefat" disabled></textarea>
    </div>
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'HTML template', 'totalpoll' ); ?>
        </label>
        <textarea type="text" class="totalpoll-settings-field-input widefat" disabled></textarea>
    </div>
    <?php TotalPoll( 'upgrade-to-pro' ); ?>
</div>
