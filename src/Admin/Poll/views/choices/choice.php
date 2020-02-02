<script type="text/ng-template" id="choice-component-template">
    <div class="totalpoll-containable-list-item" ng-class="{'active': !$ctrl.isCollapsed()}">
        <div class="totalpoll-containable-list-item-toolbar">
            <div class="totalpoll-containable-list-item-toolbar-collapse" ng-click="$ctrl.toggleCollapsed()">
                <span class="totalpoll-containable-list-item-toolbar-collapse-text">{{ $ctrl.index + 1 }}</span>
                <span class="dashicons dashicons-arrow-up" ng-if="!$ctrl.isCollapsed()"></span>
                <span class="dashicons dashicons-arrow-down" ng-if="$ctrl.isCollapsed()"></span>
            </div>
			<?php
			/**
			 * Fires before choice preview toolbar.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/before/admin/editor/choices/toolbar/preview', $this );
			?>
            <div class="totalpoll-containable-list-item-toolbar-preview" dnd-handle ng-click="$ctrl.toggleCollapsed()">
                <span class="totalpoll-containable-list-item-toolbar-preview-text">
                    {{ $ctrl.item.label || '<?php echo esc_js( __( 'Untitled', 'totalpoll' ) ); ?>' }}
	                <?php
	                /**
	                 * Fires after choice preview toolbar text.
	                 *
	                 * @since 4.0.0
	                 */
	                do_action( 'totalpoll/actions/editor/choices/toolbar/preview/text', $this );
	                ?>
                </span>
                <span class="totalpoll-containable-list-item-toolbar-preview-type">
                    <span ng-if="$ctrl.item.type === 'text'"><?php _e( 'Text', 'totalpoll' ); ?></span>
                    <span ng-if="$ctrl.item.type === 'image'"><?php _e( 'Image', 'totalpoll' ); ?></span>
                    <span ng-if="$ctrl.item.type === 'video'"><?php _e( 'Video', 'totalpoll' ); ?></span>
                    <span ng-if="$ctrl.item.type === 'audio'"><?php _e( 'Audio', 'totalpoll' ); ?></span>
                    <span ng-if="$ctrl.item.type === 'html'"><?php _e( 'HTML', 'totalpoll' ); ?></span>
					<?php
					/**
					 * Fires after choice preview toolbar type.
					 *
					 * @since 4.0.0
					 */
					do_action( 'totalpoll/actions/editor/choices/toolbar/preview/type', $this );
					?>
                </span>
            </div>
			<?php
			/**
			 * Fires after choice preview toolbar.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/after/admin/editor/choices/toolbar/preview', $this );
			?>

			<?php
			/**
			 * Fires before choice votes input.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/before/admin/editor/choices/toolbar/votes', $this );
			?>
            <div class="totalpoll-containable-list-item-toolbar-votes" ondragstart="return false;">
                <label for="{{$ctrl.prefix('votes')}}">
					<?php _e( 'Votes', 'totalpoll' ); ?>
                </label>
                <input type="number"
                       min="0"
                       placeholder="<?php _e( 'Votes', 'totalpoll' ); ?>"
                       ng-init="$ctrl.item.votesOverride || ($ctrl.item.votesOverride = 0)"
                       ng-focus="$ctrl.onOverrideVotes({$event: $event})"
                       ng-style="{'width': ( ($ctrl.item.votesOverride.toString().length * 6) + 30 )}"
                       name="{{$ctrl.prefix('votes')}}" id="{{$ctrl.prefix('votes')}}"
                       ng-model="$ctrl.item.votesOverride">
                <button type="reset" ng-if="$ctrl.item.votesOverride !== $ctrl.item.votes" class="button button-small" ng-click="$ctrl.item.votesOverride = $ctrl.item.votes">
					<?php _e( 'Revert', 'totalpoll' ); ?>
                </button>
            </div>
			<?php
			/**
			 * Fires after choice votes input.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/after/admin/editor/choices/toolbar/votes', $this );
			?>

			<?php
			/**
			 * Fires before choice visibility toggle.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/before/admin/editor/choices/toolbar/visibility', $this );
			?>
            <div class="totalpoll-containable-list-item-toolbar-visibility" ng-class="{'active': $ctrl.isVisible()}">
                <button class="button button-small" ng-click="$ctrl.toggleVisibility()" type="button">
                    <span class="dashicons dashicons-visibility"></span>
                </button>
            </div>
			<?php
			/**
			 * Fires after choice visibility toggle.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/after/admin/editor/choices/toolbar/visibility', $this );
			?>

			<?php
			/**
			 * Fires before choice delete button.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/before/admin/editor/choices/toolbar/delete', $this );
			?>
            <div class="totalpoll-containable-list-item-toolbar-delete">
                <button class="button button-danger button-small" type="button"
                        ng-click="$ctrl.onDelete()">
					<?php _e( 'Delete', 'totalpoll' ); ?>
                </button>
            </div>
			<?php
			/**
			 * Fires before choice delete button.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/after/admin/editor/choices/toolbar/delete', $this );
			?>
        </div>

		<?php
		/**
		 * Fires before choice content.
		 *
		 * @since 4.0.0
		 */
		do_action( 'totalpoll/actions/before/admin/editor/choices/content', $this );
		?>
        <div class="totalpoll-containable-list-item-editor"
             ondragstart="return false;"
             ng-include="'choice-type-' + $ctrl.item.type + '-template'"
             ng-hide="$ctrl.isCollapsed()">
        </div>
		<?php
		/**
		 * Fires after choice content.
		 *
		 * @since 4.0.0
		 */
		do_action( 'totalpoll/actions/after/admin/editor/choices/content', $this );
		?>
    </div>
</script>
