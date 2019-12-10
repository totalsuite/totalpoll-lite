<script type="text/ng-template" id="dashboard-overview-component-template">
    <div class="totalpoll-box">
        <div class="totalpoll-create-poll" ng-if="$ctrl.polls != null && !$ctrl.polls.length">
            <img src="<?php echo esc_attr( $this->env['url'] ); ?>assets/dist/images/general/create-poll.svg">
            <div class="totalpoll-box-title"><?php _e( 'It\'s time to create your first poll.', 'totalpoll' ); ?></div>
            <div class="totalpoll-box-description"><?php _e( 'There are no polls yet.', 'totalpoll' ); ?></div>
            <a href="<?php echo esc_attr( admin_url( 'post-new.php?post_type=poll' ) ); ?>"
               class="button button-large button-primary"><?php _e( 'Create Poll', 'totalpoll' ); ?>
            </a>
        </div>
        <div class="totalpoll-overview" ng-class="{'totalpoll-processing': $ctrl.polls === null}">
            <div class="totalpoll-overview-item" ng-repeat="poll in $ctrl.polls">
                <a class="totalpoll-overview-item-segment totalpoll-overview-item-title" ng-href="{{ poll.editLink }}">
                    {{ poll.title || '<?php _e( 'Untitled', 'totalpoll' ); ?>' }}
                    <span class="totalpoll-overview-item-status" ng-class="{'active': poll.status == 'publish'}">
                        {{ poll.status === 'publish' ? '<?php _e( 'Live', 'totalpoll' ); ?>' : '<?php _e( 'Pending', 'totalpoll' ); ?>'}}
                    </span>
                </a>
                <a class="totalpoll-overview-item-segment totalpoll-overview-item-action" ng-href="{{ poll.permalink }}" target="_blank">
                    <span class="dashicons dashicons-external"></span>
                </a>
                <div class="totalpoll-overview-item-segment totalpoll-overview-item-number">
                    <span class="dashicons dashicons-chart-bar"></span>
                    <span>{{poll.statistics.votes|number}} <?php _e( 'Votes', 'totalpoll' ); ?></span>
                </div>
                <div class="totalpoll-overview-item-segment totalpoll-overview-item-number">
                    <span class="dashicons dashicons-admin-users"></span>
                    <span>{{poll.statistics.entries|number}} <?php _e( 'Entries', 'totalpoll' ); ?></span>
                </div>
            </div>
        </div>
    </div>
</script>