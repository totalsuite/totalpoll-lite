<div id="totalpoll-entries" class="wrap totalpoll-page" ng-app="entries">
    <h1 class="totalpoll-page-title"><?php _e( 'Entries', 'totalpoll' ); ?></h1>
    <entries-browser></entries-browser>
    <script type="text/ng-template" id="entries-browser-component-template">
        <table class="wp-list-table widefat striped totalpoll-entries-browser-list" ng-class="{'totalpoll-processing': $ctrl.isProcessing()}">
            <thead class="totalpoll-entries-browser-list-header-wrapper">
            <tr>
                <td colspan="{{ $ctrl.getFields().length + 1 }}">
                    <div class="totalpoll-entries-browser-list-header">
                        <div class="totalpoll-entries-browser-list-header-polls">
                            <select ng-model="$ctrl.filters.poll" ng-options="poll.id as poll.title for poll in $ctrl.polls" ng-change="$ctrl.loadPage(1)">
                                <option value=""><?php _e( 'Please select a poll', 'totalpoll' ); ?></option>
                            </select>
                        </div>
                        <div class="totalpoll-entries-browser-list-header-date">
                            <span><?php _e( 'From', 'totalpoll' ); ?></span>
                            <input type="text" datetime-picker='{"timepicker":false, "mask":true, "format": "Y-m-d"}' ng-model="$ctrl.filters.from">
                            <span><?php _e( 'To', 'totalpoll' ); ?></span>
                            <input type="text" datetime-picker='{"timepicker":false, "mask":true, "format": "Y-m-d"}' ng-model="$ctrl.filters.to">
							<?php
							/**
							 * Fires after filter inputs in entries browser interface.
							 *
							 * @since 4.0.0
							 */
							do_action( 'totalpoll/actions/admin/entries/filters' );
							?>
                            <div class="button-group">
                                <button class="button" ng-click="$ctrl.resetFilters()" ng-disabled="!($ctrl.filters.from || $ctrl.filters.to)">
									<?php _e( 'Clear', 'totalpoll' ); ?>
                                </button>
                                <button class="button button-primary" ng-click="$ctrl.loadPage(1)">
									<?php _e( 'Apply', 'totalpoll' ); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="col" class="totalpoll-entries-browser-list-collapsed" ng-repeat="field in $ctrl.getFields()">{{ field.label || field.name }}</th>
                <th scope="col" class="totalpoll-entries-browser-list-collapsed" ng-if="$ctrl.entries.length > 0"><?php _e( 'Date', 'totalpoll' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="totalpoll-entries-browser-list-entry" ng-repeat="entry in $ctrl.entries track by $index">
                <td class="totalpoll-entries-browser-list-collapsed" ng-repeat="field in $ctrl.getFields()">{{ entry.getField(field.name) || 'N/A' }}</td>
                <td class="totalpoll-entries-browser-list-collapsed">{{ entry.getDate()|date:'yyyy-MM-dd @ HH:mm' }}</td>
            </tr>
            <tr ng-if="!$ctrl.entries.length">
                <td colspan="{{$ctrl.getFields().length}}"><?php _e( 'Nothing. Nada. Niente. Nickts. Rien.', 'totalpoll' ); ?></td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="totalpoll-entries-browser-list-footer-wrapper">
                <td scope="col" colspan="{{ $ctrl.getFields().length + 1 }}">
                    <div class="totalpoll-entries-browser-list-footer">
                        <div class="totalpoll-entries-browser-list-footer-pagination">
                            <div class="button-group">
                                <button class="button" ng-class="{'button-primary': $ctrl.hasPreviousPage()}" ng-click="$ctrl.previousPage()"
                                        ng-disabled="$ctrl.isFirstPage()"><?php _e( 'Previous', 'totalpoll' ); ?></button>
                                <button class="button" ng-class="{'button-primary': $ctrl.hasNextPage()}" ng-click="$ctrl.nextPage()"
                                        ng-disabled="$ctrl.isLastPage()"><?php _e( 'Next', 'totalpoll' ); ?></button>
                            </div>
                        </div>
                        <div class="totalpoll-entries-browser-list-footer-export">
                            <span><?php _e( 'Download as', 'totalpoll' ); ?></span>
                            <div class="button-group">
								<?php foreach ( $formats as $format => $label ): ?>
                                    <button class="button" ng-class="{'button-primary': $ctrl.canExport()}" ng-click="$ctrl.exportAs('<?php echo esc_js( $format ); ?>')" ng-disabled="!$ctrl.canExport()"><?php echo esc_html( $label ); ?></button>
								<?php endforeach; ?>
                                
                                <button class="button button-primary" disabled>CSV <?php TotalPoll( 'upgrade-to-pro' ); ?></button>
                                <button class="button button-primary" disabled>JSON <?php TotalPoll( 'upgrade-to-pro' ); ?></button>
								
                            </div>
                        </div>

                    </div>
                </td>
            </tr>
            </tfoot>

        </table>
    </script>

</div>
