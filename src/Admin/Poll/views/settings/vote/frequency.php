<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <p>
			<?php _e( 'Block based on', 'totalpoll' ); ?>
            <span
                    class="totalpoll-feature-details"
                    tooltip="<?php _e( 'The methods used to block exceeding the limits of voting.', 'totalpoll' ); ?>">?</span>
        </p>
        <div class="totalpoll-settings-field">
            <label>
                <input type="checkbox" name=""
                       ng-model="editor.settings.vote.frequency.cookies.enabled">
				<?php _e( 'Cookies', 'totalpoll' ); ?>
            </label>
        </div>
        <div class="totalpoll-settings-field">
            <label> <input type="checkbox" name=""
                           disabled>
				<?php _e( 'IP', 'totalpoll' ); ?>
                <?php TotalPoll( 'upgrade-to-pro' ); ?>
            </label>
        </div>
        <div class="totalpoll-settings-field">
            <label> <input type="checkbox" name=""
                           disabled>
				<?php _e( 'Authenticated user', 'totalpoll' ); ?>
                <?php TotalPoll( 'upgrade-to-pro' ); ?>
            </label>
        </div>
    </div>
</div>
<div class="totalpoll-settings-item totalpoll-settings-item-inline">
    <div class="totalpoll-settings-field" ng-if="editor.settings.vote.frequency.cookies.enabled">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Votes per session', 'totalpoll' ); ?>
            <span class="totalpoll-feature-details"
                  tooltip="<?php _e( 'How many times can the user vote using the same session.', 'totalpoll' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalpoll-settings-field-input widefat"
               ng-model="editor.settings.vote.frequency.perSession"
               ng-disabled="!(editor.settings.vote.frequency.cookies.enabled || editor.settings.vote.frequency.ip.enabled || editor.settings.vote.frequency.user.enabled)">
    </div>

    <div class="totalpoll-settings-field" ng-if="editor.settings.vote.frequency.user.enabled">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Votes per user', 'totalpoll' ); ?>
            <span class="totalpoll-feature-details"
                  tooltip="<?php _e( 'How many times can the authenticated user vote.', 'totalpoll' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalpoll-settings-field-input widefat"
               ng-model="editor.settings.vote.frequency.perUser"
               ng-disabled="!(editor.settings.vote.frequency.cookies.enabled || editor.settings.vote.frequency.ip.enabled || editor.settings.vote.frequency.user.enabled)">
    </div>

    <div class="totalpoll-settings-field" ng-if="editor.settings.vote.frequency.ip.enabled">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Votes per IP', 'totalpoll' ); ?>
            <span class="totalpoll-feature-details"
                  tooltip="<?php _e( 'How many times can the user vote using the same IP.', 'totalpoll' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalpoll-settings-field-input widefat"
               ng-model="editor.settings.vote.frequency.perIP">
    </div>
</div>
<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Timeout (minutes)', 'totalpoll' ); ?>
            <span class="totalpoll-feature-details"
                  tooltip="<?php _e( 'The time period before the user can vote again.', 'totalpoll' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalpoll-settings-field-input widefat"
               ng-model="editor.settings.vote.frequency.timeout"
               ng-disabled="!(editor.settings.vote.frequency.cookies.enabled || editor.settings.vote.frequency.ip.enabled || editor.settings.vote.frequency.user.enabled)">
        <p class="totalpoll-feature-tip">
			<?php _e( 'After this period, users will be able to vote again. To lock the vote permanently, use 0 as a value.', 'totalpoll' ); ?>
        </p>
        <p class="totalpoll-warning" ng-if="editor.settings.vote.frequency.timeout == 0">
			<?php _e( 'Heads up! The database will be filled with permanent records which may affect the overall performance.', 'totalpoll' ); ?>
        </p>
    </div>
</div>
