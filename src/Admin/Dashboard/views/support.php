<script type="text/ng-template" id="dashboard-support-component-template">
    <div class="totalpoll-box totalpoll-box-support-search">
        <div class="totalpoll-box-title"><?php _e( 'How can we help you?', 'totalpoll' ); ?></div>
        <div class="totalpoll-box-description"><?php _e( 'Search our knowledge base for detailed answers and tutorials.', 'totalpoll' ); ?></div>
        <form action="<?php echo esc_attr( $this->env['links.search'] ); ?>" method="get" target="_blank" class="totalpoll-box-composed-form">
            <input type="text" name="s" class="totalpoll-box-composed-form-field" placeholder="<?php esc_attr_e( 'Enter some keywords', 'totalpoll' ); ?>">
            <input type="hidden" name="search_product" value="totalpoll">
            <input type="hidden" name="search_source" value="inapp">
            <button type="submit" class="button button-primary button-large totalpoll-box-composed-form-button"><?php _e( 'Search', 'totalpoll' ); ?></button>
        </form>
    </div>
    <div class="totalpoll-row">
        <div class="totalpoll-column">
            <div class="totalpoll-box totalpoll-box-support-channel">
                <div class="totalpoll-box-section">
                    <img class="totalpoll-box-support-channel-image" src="<?php echo esc_attr( $this->env['url'] ); ?>assets/dist/images/support/community-support.svg">
                    <div class="totalpoll-box-title"><?php _e( 'Community Support', 'totalpoll' ); ?></div>
                    <div class="totalpoll-box-description"><?php _e( 'Join and ask TotalSuite community for help.', 'totalpoll' ); ?></div>
                    <a href="<?php echo esc_attr( $this->env['links.forums'] ); ?>" target="_blank" class="button button-primary button-large"><?php _e( 'Visit Forums', 'totalpoll' ); ?></a>
                </div>
            </div>
        </div>
        <div class="totalpoll-column">
            <div class="totalpoll-box totalpoll-box-support-channel">
                <div class="totalpoll-box-section">
                    <img class="totalpoll-box-support-channel-image" src="<?php echo esc_attr( $this->env['url'] ); ?>assets/dist/images/support/customer-support.svg">
                    <div class="totalpoll-box-title"><?php _e( 'Customer Support', 'totalpoll' ); ?></div>
                    <div class="totalpoll-box-description"><?php _e( 'Our support team is here to help you.', 'totalpoll' ); ?></div>
                    <a href="<?php echo esc_attr( $this->env['links.support'] ); ?>" target="_blank" class="button button-primary button-large"><?php _e( 'Send Ticket', 'totalpoll' ); ?></a>
                </div>
            </div>
        </div>
        <div class="totalpoll-column">
            <div class="totalpoll-box totalpoll-box-support-channel">
                <div class="totalpoll-box-section">
                    <img class="totalpoll-box-support-channel-image" src="<?php echo esc_attr( $this->env['url'] ); ?>assets/dist/images/support/instant-support.svg">
                    <div class="totalpoll-box-title"><?php _e( 'Instant Support', 'totalpoll' ); ?></div>
                    <div class="totalpoll-box-description"><?php _e( 'You\'re in a hurry? We\'ve got your back!', 'totalpoll' ); ?></div>
                    <a href="<?php echo esc_attr( $this->env['links.support'] ); ?>" target="_blank" class="button button-primary button-large"><?php _e( 'Learn More', 'totalpoll' ); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="totalpoll-row">
        <div class="totalpoll-column totalpoll-column-6" ng-repeat="section in $ctrl.sections">
            <dashboard-links
                    heading="section.title"
                    description="section.description"
                    links="section.links">
            </dashboard-links>
        </div>
    </div>
</script>
<script type="text/ng-template" id="dashboard-links-component-template">
    <div class="totalpoll-box totalpoll-box-links">
        <div class="totalpoll-box-section">
            <div class="totalpoll-box-title">{{ $ctrl.heading }}</div>
            <div class="totalpoll-box-description">{{ $ctrl.description }}</div>
        </div>
        <div class="totalpoll-box-links-item" ng-repeat="link in $ctrl.links">
            <a href="{{ link.url }}" target="_blank" title="{{link.title}}">{{ link.title }}</a>
        </div>
    </div>
</script>