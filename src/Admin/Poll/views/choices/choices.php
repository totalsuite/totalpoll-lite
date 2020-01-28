<script type="text/ng-template" id="choices-component-template">
    <div ng-show="$ctrl.droppable" class="totalpoll-droppable">
        <span class="totalpoll-droppable-content"><?php _e( 'Drop to add', 'totalpoll' ); ?></span>
    </div>

	<?php
	/**
	 * Fires before choices.
	 *
	 * @since 4.0.0
	 */
	do_action( 'totalpoll/actions/before/admin/editor/choices', $this );
	?>

    <div class="totalpoll-containable-toolbar">
        <div class="button-group">
			<?php
			/**
			 * Fires at the 1st position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/1', $this );
			?>
            <button type="button" class="button button-large" ng-click="$ctrl.collapseChoices()" ng-disabled="$ctrl.items.length === 0">
				<?php _e( 'Collapse', 'totalpoll' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 2nd position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/2', $this );
			?>
            <button type="button" class="button button-large" ng-click="$ctrl.expandChoices()" ng-disabled="$ctrl.items.length === 0">
				<?php _e( 'Expand', 'totalpoll' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 3rd position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/3', $this );
			?>
        </div>

        <div class="button-group">
			<?php
			/**
			 * Fires at the 4th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/4', $this );
			?>
            <button type="button" class="button button-large" disabled>
				<?php _e( 'Bulk', 'totalpoll' ); ?>
                <?php TotalPoll( 'upgrade-to-pro' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 5th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/5', $this );
			?>
            <button type="button" class="button button-large" ng-click="$ctrl.shuffleChoices()" ng-disabled="$ctrl.items.length < 2">
				<?php _e( 'Shuffle', 'totalpoll' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 6th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/6', $this );
			?>
            <button type="button" class="button button-large" ng-click="$ctrl.randomVotes()" ng-disabled="$ctrl.items.length === 0">
				<?php _e( 'Random Votes', 'totalpoll' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 7th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/7', $this );
			?>
        </div>

        <div class="button-group">
			<?php
			/**
			 * Fires at the 8th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/8', $this );
			?>
            <button type="button" class="button button-large" disabled ng-disabled="$ctrl.items.length === 0">
				<?php _e( 'Filter', 'totalpoll' ); ?>
                <?php TotalPoll( 'upgrade-to-pro' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 9th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/9', $this );
			?>
            <button type="button" class="button button-large button-danger" ng-click="$ctrl.deleteChoices()" ng-disabled="$ctrl.items.length === 0">
				<?php _e( 'Delete All', 'totalpoll' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 10th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/10', $this );
			?>
            <button type="button" class="button button-large button-danger" ng-click="$ctrl.resetVotes()" ng-disabled="$ctrl.items.length === 0">
				<?php _e( 'Reset Votes', 'totalpoll' ); ?>
            </button>
			<?php
			/**
			 * Fires at the 11th position of toolbar buttons.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/editor/choices/toolbar/11', $this );
			?>
        </div>
    </div>

    <div class="totalpoll-containable-bulk" ng-if="$ctrl.bulkInput">
        <textarea name="" ng-model="$ctrl.bulkContent" rows="6" placeholder="<?php _e( 'One choice per line.', 'totalpoll' ); ?>"></textarea>
        <button type="button" class="button button-large" ng-click="$ctrl.insertBulkChoices()">
			<?php _e( 'Insert', 'totalpoll' ); ?>
        </button>
    </div>

    <div class="totalpoll-containable-types" ng-if="$ctrl.filterList">
        <label class="totalpoll-containable-types-item">
            <input type="checkbox" ng-model="$ctrl.types.text">
			<?php _e( 'Text', 'totalpoll' ); ?>
        </label>
        <label class="totalpoll-containable-types-item">
            <input type="checkbox" ng-model="$ctrl.types.image">
			<?php _e( 'Image', 'totalpoll' ); ?>
        </label>
        <label class="totalpoll-containable-types-item">
            <input type="checkbox" ng-model="$ctrl.types.video">
			<?php _e( 'Video', 'totalpoll' ); ?>
        </label>
        <label class="totalpoll-containable-types-item">
            <input type="checkbox" ng-model="$ctrl.types.audio">
			<?php _e( 'Audio', 'totalpoll' ); ?>
        </label>
        <label class="totalpoll-containable-types-item">
            <input type="checkbox" ng-model="$ctrl.types.html">
			<?php _e( 'HTML', 'totalpoll' ); ?>
        </label>
    </div>

    <div class="totalpoll-empty-state" ng-if="$ctrl.items.length === 0" ondragstart="return false;">
        <div class="totalpoll-empty-state-text">
			<?php _e( 'No choices yet. Add some by clicking on buttons below.', 'totalpoll' ); ?>
        </div>
    </div>
    <div class="totalpoll-containable-list"
         dnd-list="$ctrl.items"
         dnd-disable-if="$ctrl.items.length < 2">
        <dnd-nodrag ng-repeat="item in $ctrl.items"
                    dnd-draggable="item"
                    dnd-effect-allowed="move"
                    ng-show="$ctrl.isTypeActive(item.type)"
                    dnd-moved="$ctrl.deleteChoice($index, true)">
            <choice item="item"
                    index="$index"
                    on-delete="$ctrl.deleteChoice($index)"
                    on-override-votes="$ctrl.confirmOverride($event)"></choice>
        </dnd-nodrag>
        <div class="dndPlaceholder totalpoll-list-placeholder">
            <div class="totalpoll-list-placeholder-text">
				<?php _e( 'Move here', 'totalpoll' ); ?>
            </div>
        </div>
    </div>

    <div class="totalpoll-buttons-horizontal">
        <div class="totalpoll-buttons-horizontal-item" ng-click="$ctrl.insertChoice({type: 'text'})">
            <div class="dashicons dashicons-editor-textcolor"></div>
            <div class="totalpoll-buttons-horizontal-item-title">
				<?php _e( 'Text', 'totalpoll' ); ?>
            </div>
        </div>
        <div class="totalpoll-buttons-horizontal-item totalpoll-pro-badge-container" disabled>
            <div class="dashicons dashicons-format-image"></div>
            <div class="totalpoll-buttons-horizontal-item-title">
				<?php _e( 'Image', 'totalpoll' ); ?>
            </div>
            <?php TotalPoll( 'upgrade-to-pro' ); ?>
        </div>
        <div class="totalpoll-buttons-horizontal-item totalpoll-pro-badge-container" disabled>
            <div class="dashicons dashicons-format-video"></div>
            <div class="totalpoll-buttons-horizontal-item-title">
				<?php _e( 'Video', 'totalpoll' ); ?>
            </div>
            <?php TotalPoll( 'upgrade-to-pro' ); ?>
        </div>
        <div class="totalpoll-buttons-horizontal-item totalpoll-pro-badge-container" disabled>
            <div class="dashicons dashicons-format-audio"></div>
            <div class="totalpoll-buttons-horizontal-item-title">
				<?php _e( 'Audio', 'totalpoll' ); ?>
            </div>
            <?php TotalPoll( 'upgrade-to-pro' ); ?>
        </div>
        <div class="totalpoll-buttons-horizontal-item totalpoll-pro-badge-container" disabled>
            <div class="dashicons dashicons-editor-code"></div>
            <div class="totalpoll-buttons-horizontal-item-title">
				<?php _e( 'HTML', 'totalpoll' ); ?>
            </div>
            <?php TotalPoll( 'upgrade-to-pro' ); ?>
        </div>
		<?php do_action( 'totalpoll/actions/editor/choices/types', $this ); ?>
    </div>


	<?php
	/**
	 * Fires after choices.
	 *
	 * @since 4.0.0
	 */
	do_action( 'totalpoll/actions/after/admin/editor/choices', $this );
	?>
</script>
