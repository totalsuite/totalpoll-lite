<div class="totalpoll-settings-item totalpoll-pro-badge-container">
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Recipient email', 'totalpoll' ); ?>
        </label>
        <input type="text" class="totalpoll-settings-field-input widefat" disabled dir="ltr">
    </div>
    <?php TotalPoll( 'upgrade-to-pro' ); ?>
</div>
<div class="totalpoll-settings-item totalpoll-pro-badge-container">
    <p>
		<?php _e( 'Send notification when', 'totalpoll' ); ?>
    </p>
    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" disabled ng-checked="editor.settings.notifications.email.on.newVote">
			<?php _e( 'New vote has been casted', 'totalpoll' ); ?>
        </label>
    </div>
    <?php TotalPoll( 'upgrade-to-pro' ); ?>
</div>
