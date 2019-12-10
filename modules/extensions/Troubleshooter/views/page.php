<div id="totalpoll-troubleshooter" class="wrap totalpoll-page" ng-app="troubleshooter" ng-controller="TroubleshooterCtrl as troubleshooter" ng-cloak="">
    <h1 class="totalpoll-page-title">
		<?php _e( 'Troubleshooter', 'totalpoll' ); ?>
        <button type="button" ng-click="troubleshooter.run()" class="page-title-action" role="button" ng-disabled="troubleshooter.isProcessing()">
            <span ng-if="!troubleshooter.isProcessing()"><?php _e( 'Run', 'totalpoll' ); ?></span>
            <span ng-if="troubleshooter.isProcessing()"><?php _e( 'Running', 'totalpoll' ); ?></span>
        </button>
    </h1>

    <div class="totalpoll-troubleshooter-tests">
        <div class="totalpoll-troubleshooter-test" ng-repeat="test in troubleshooter.tests" ng-class="{'running': test.running, 'errors':test.errors, 'warnings':test.warnings, 'done':test.done}">
            <div class="totalpoll-troubleshooter-test-status"></div>
            <div class="totalpoll-troubleshooter-test-body">
                <div class="totalpoll-troubleshooter-test-name">
                    {{ test.name }}
                    <span ng-if="test.running">&mdash; <?php _e( 'Running', 'totalpoll' ); ?></span>
                    <span ng-if="test.done">&mdash; <?php _e( 'Passed', 'totalpoll' ); ?></span>
                    <span ng-if="test.errors">&mdash; <?php _e( 'Failed', 'totalpoll' ); ?></span>
                    <span ng-if="test.warnings">&mdash; <?php _e( 'Warning', 'totalpoll' ); ?></span>
                </div>
                <div class="totalpoll-troubleshooter-test-description">{{ test.description }}</div>
                <div class="totalpoll-troubleshooter-test-errors" ng-if="test.errors" ng-bind-html="test.errors"></div>
                <div class="totalpoll-troubleshooter-test-warnings" ng-if="test.warnings" ng-bind-html="test.warnings"></div>
                <div class="totalpoll-troubleshooter-test-actions">
                    <button type="button" class="button button-small" ng-if="test.fixable" ng-click="troubleshooter.fix(test)" ng-disabled="test.fixing"><?php _e( 'Fix', 'totalpoll' ); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>