<script type="text/ng-template" id="fields-component-template">
    <div class="totalpoll-fields">
		<?php
		/**
		 * Fires before fields.
		 *
		 * @since 4.0.0
		 */
		do_action( 'totalpoll/actions/before/admin/editor/fields', $this );
		?>
        <div class="totalpoll-fields-sidebar">
            <h3 class="totalpoll-h3"><?php _e( 'Preset', 'totalpoll' ); ?></h3>

            <button type="button" class="button button-large" ng-click="$ctrl.insertFieldFromPreset('First name*')"><?php _e( 'First name', 'totalpoll' ); ?></button>
            <button type="button" class="button button-large" ng-click="$ctrl.insertFieldFromPreset('Last name*')"><?php _e( 'Last name', 'totalpoll' ); ?></button>
            <button type="button" class="button button-large" ng-click="$ctrl.insertFieldFromPreset('Email*')"><?php _e( 'Email', 'totalpoll' ); ?></button>
            <button type="button" class="button button-large" disabled><?php _e( 'Phone', 'totalpoll' ); ?><?php TotalPoll( 'upgrade-to-pro' ); ?></button>
            <button type="button" class="button button-large" disabled><?php _e( 'Gender', 'totalpoll' ); ?><?php TotalPoll( 'upgrade-to-pro' ); ?></button>
            <button type="button" class="button button-large" disabled><?php _e( 'Country', 'totalpoll' ); ?><?php TotalPoll( 'upgrade-to-pro' ); ?></button>
            <button type="button" class="button button-large" disabled><?php _e( 'Agreement', 'totalpoll' ); ?><?php TotalPoll( 'upgrade-to-pro' ); ?></button>
			<?php
			/**
			 * Fires after field presets.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/before/admin/editor/fields/presets', $this );
			?>
        </div>
        <div class="totalpoll-fields-content">
            <h3 class="totalpoll-h3"><?php _e( 'Fields', 'totalpoll' ); ?></h3>
			<?php
			/**
			 * Fires before fields toolbar.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/before/admin/editor/fields/toolbar', $this );
			?>
            <div class="totalpoll-containable-toolbar">
                <div class="button-group">
					<?php
					/**
					 * Fires at the 1st position of toolbar buttons.
					 *
					 * @since 4.0.0
					 */
					do_action( 'totalpoll/actions/editor/fields/toolbar', 1, $this );
					?>
                    <button type="button" class="button button-large" ng-click="$ctrl.collapseFields()"><?php _e( 'Collapse', 'totalpoll' ); ?></button>
					<?php
					/**
					 * Fires at the 2nd position of toolbar buttons.
					 *
					 * @since 4.0.0
					 */
					do_action( 'totalpoll/actions/editor/fields/toolbar', 2, $this );
					?>
                    <button type="button" class="button button-large" ng-click="$ctrl.expandFields()"><?php _e( 'Expand', 'totalpoll' ); ?></button>
					<?php
					/**
					 * Fires at the 3rd position of toolbar buttons.
					 *
					 * @since 4.0.0
					 */
					do_action( 'totalpoll/actions/editor/fields/toolbar', 3, $this );
					?>
                    <button type="button" class="button button-large" disabled><?php _e( 'Bulk', 'totalpoll' ); ?><?php TotalPoll( 'upgrade-to-pro' ); ?></button>
					<?php
					/**
					 * Fires at the 4th position of toolbar buttons.
					 *
					 * @since 4.0.0
					 */
					do_action( 'totalpoll/actions/editor/fields/toolbar', 4, $this );
					?>
                </div>

				<?php
				/**
				 * Fires at the 5th position of toolbar buttons.
				 *
				 * @since 4.0.0
				 */
				do_action( 'totalpoll/actions/editor/fields/toolbar', 5, $this );
				?>
                <button type="button" class="button button-large button-danger" ng-click="$ctrl.deleteFields()">
					<?php _e( 'Delete All', 'totalpoll' ); ?>
                </button>
				<?php
				/**
				 * Fires at the 6th position of toolbar buttons.
				 *
				 * @since 4.0.0
				 */
				do_action( 'totalpoll/actions/editor/fields/toolbar', 6, $this );
				?>
            </div>
			<?php
			/**
			 * Fires after fields toolbar.
			 *
			 * @since 4.0.0
			 */
			do_action( 'totalpoll/actions/after/admin/editor/fields/toolbar', $this );
			?>

            <div class="totalpoll-containable-bulk" ng-if="$ctrl.bulkInput">
                <textarea name="" ng-model="$ctrl.bulkContent" rows="6" placeholder="<?php esc_attr_e( 'One field per line.', 'totalpoll' ); ?>"></textarea>
                <button type="button" class="button button-large" ng-click="$ctrl.insertBulkFields()"><?php _e( 'Insert', 'totalpoll' ); ?></button>
            </div>

            <div class="totalpoll-empty-state" ng-if="$ctrl.items.length === 0">
                <div class="totalpoll-empty-state-text"><?php _e( 'No custom fields yet. Add some by clicking on buttons below.', 'totalpoll' ); ?></div>
            </div>

            <div class="totalpoll-containable-list"
                 dnd-list="$ctrl.items"
                 dnd-disable-if="$ctrl.items.length < 2">
                <dnd-nodrag ng-repeat="item in $ctrl.items"
                            dnd-draggable="item"
                            dnd-effect-allowed="move"
                            dnd-moved="$ctrl.deleteField($index, true)">
                    <field item="item" index="$index" on-delete="$ctrl.deleteField($index)"></field>
                </dnd-nodrag>
                <div class="dndPlaceholder totalpoll-list-placeholder">
                    <div class="totalpoll-list-placeholder-text"><?php _e( 'Move here', 'totalpoll' ); ?></div>
                </div>
            </div>

            <div class="totalpoll-buttons-horizontal">
				<?php
				/**
				 * Fires before field types.
				 *
				 * @since 4.0.0
				 */
				do_action( 'totalpoll/actions/before/admin/editor/fields/types', $this );

				$types = apply_filters( 'totalpoll/filters/admin/editor/fields/types',
					[
						'text'     => [ 'label' => __( 'Text', 'totalpoll' ), 'icon' => 'editor-textcolor', 'args' => [ 'type' => 'text' ] ],
						'textarea' => [ 'label' => __( 'Textarea', 'totalpoll' ), 'icon' => 'text', 'args' => [ 'type' => 'textarea' ] ],
						'select'   => [ 'label' => __( 'Select', 'totalpoll' ), 'icon' => 'menu', 'args' => [ 'type' => 'select' ] ],
						'checkbox' => [ 'label' => __( 'Checkbox', 'totalpoll' ), 'icon' => 'yes', 'args' => [ 'type' => 'checkbox' ] ],
						'radio'    => [ 'label' => __( 'Radio', 'totalpoll' ), 'icon' => 'marker', 'args' => [ 'type' => 'radio' ] ],
					]
				);
                
				$proTypes = [ 'select', 'textarea', 'select', 'checkbox', 'radio' ];
				
				?>

				<?php foreach ( $types as $typeId => $type ): ?>
                    

                    
					<?php if ( in_array( $typeId, $proTypes ) ): ?>
                    <div class="totalpoll-buttons-horizontal-item totalpoll-pro-badge-container" disabled>
                        <div class="dashicons dashicons-<?php echo esc_attr( $type['icon'] ); ?>"></div>
                        <div class="totalpoll-buttons-horizontal-item-title"><?php echo esc_html( $type['label'] ); ?></div>
                        <?php TotalPoll( 'upgrade-to-pro' ); ?>
                    </div>
                    <?php else: ?>
                    <div class="totalpoll-buttons-horizontal-item" ng-click="$ctrl.insertField(<?php echo esc_js( json_encode( $type['args'] ) ); ?>)">
                        <div class="dashicons dashicons-<?php echo esc_attr( $type['icon'] ); ?>"></div>
                        <div class="totalpoll-buttons-horizontal-item-title"><?php echo esc_html( $type['label'] ); ?></div>
                    </div>
					<?php endif; ?>
                    
				<?php endforeach; ?>

				<?php
				/**
				 * Fires after field types.
				 *
				 * @since 4.0.0
				 */
				do_action( 'totalpoll/actions/after/admin/editor/fields/types', $this );
				?>
            </div>
        </div>
		<?php
		/**
		 * Fires after fields.
		 *
		 * @since 4.0.0
		 */
		do_action( 'totalpoll/actions/after/admin/editor/fields', $this );
		?>
    </div>
</script>
