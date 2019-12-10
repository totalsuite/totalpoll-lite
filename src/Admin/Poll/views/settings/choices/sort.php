<div class="totalpoll-settings-item">
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Sort choices by', 'totalpoll' ); ?>
        </label>

        <p>
            <label>
                <input type="radio" name="" value="position" ng-model="editor.settings.choices.sort.field">
				<?php _e( 'Position', 'totalpoll' ); ?>
            </label>
            &nbsp;&nbsp;
            <label>
                <input type="radio" name="" value="votes" ng-model="editor.settings.choices.sort.field">
				<?php _e( 'Votes', 'totalpoll' ); ?>
            </label>
            &nbsp;&nbsp;
            <label>
                <input type="radio" name="" value="label" disabled>
				<?php _e( 'Label', 'totalpoll' ); ?>
                <?php TotalPoll( 'upgrade-to-pro' ); ?>
            </label>
            &nbsp;&nbsp;
            <label>
                <input type="radio" name="" value="random" disabled>
				<?php _e( 'Random', 'totalpoll' ); ?>
                <?php TotalPoll( 'upgrade-to-pro' ); ?>
            </label>
        </p>

    </div>
</div>
<div class="totalpoll-settings-item" ng-if="editor.settings.choices.sort.field !== 'random'">
    <div class="totalpoll-settings-field">
        <label class="totalpoll-settings-field-label">
			<?php _e( 'Direction', 'totalpoll' ); ?>
        </label>

        <p>
            <label>
                <input type="radio" name="" value="DESC" ng-model="editor.settings.choices.sort.direction">
				<?php _e( 'Descending', 'totalpoll' ); ?>
            </label>
            &nbsp;&nbsp;
            <label>
                <input type="radio" name="" value="ASC" ng-model="editor.settings.choices.sort.direction">
				<?php _e( 'Ascending', 'totalpoll' ); ?>
            </label>
        </p>
    </div>
</div>
