<customizer-control
        type="checkbox"
        label="<?php _e( 'AJAX', 'totalpoll' ); ?>"
        ng-model="$root.settings.design.behaviours.ajax"
        help="<?php _e( 'Load poll in-place without reloading the whole page.', 'totalpoll' ); ?>"></customizer-control>
<customizer-control
        type="checkbox"
        label="<?php _e( 'Scroll up after vote submission', 'totalpoll' ); ?>"
        ng-model="$root.settings.design.behaviours.scrollUp"
        help="<?php _e( 'Scroll up to poll viewport after submitting a vote.', 'totalpoll' ); ?>"></customizer-control>



<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" disabled>
			<?php _e( 'One-click vote', 'totalpoll' ); ?>
			<?php TotalPoll( 'upgrade-to-pro' ); ?>
            <span class="totalpoll-feature-details" tooltip="<?php _e( 'The user will be able to vote by clicking on the choice directly.', 'totalpoll' ); ?>">?</span>
        </label>
    </div>

    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" disabled>
			<?php _e( 'Question by question', 'totalpoll' ); ?>
			<?php TotalPoll( 'upgrade-to-pro' ); ?>
            <span class="totalpoll-feature-details" tooltip="<?php _e( 'Display questions one by one.', 'totalpoll' ); ?>">?</span>
        </label>
    </div>
</div>

