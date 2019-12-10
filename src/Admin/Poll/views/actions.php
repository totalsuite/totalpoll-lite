<div class="totalpoll-box-actions">
	<?php foreach ( $actions as $actionId => $action ): ?>
        <a href="<?php echo esc_attr( $action['url'] ); ?>" class="totalpoll-box-action totalpoll-pro-badge-container">
            <div class="totalpoll-box-action-icon">
                <span class="dashicons dashicons-<?php echo esc_attr( $action['icon'] ); ?>"></span>
            </div>
            <div class="totalpoll-box-action-name">
				<?php echo esc_html( $action['label'] ); ?>
            </div>
        </a>
        
		<?php if ( $action === 'insights' ): ?>
            <?php TotalPoll( 'upgrade-to-pro' ); ?>
		<?php endif; ?>
        
	<?php endforeach; ?>
</div>
