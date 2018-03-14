</main>

<aside id="rights" class="sidebar right">
	<?php

	$rights_statement = get_field( 'rights_statement' );
	if ( $rights_statement ) {
		echo '<section id="rights-statement" class="meta">
		<h2>Rights Statement</h2>
		<p>';
		if ( $rights_statement['value'] !== 'other' ) {
			echo '<a href="' . $rights_statement['value'] . '" rel="nofollow noreferer">' . $rights_statement['label'] . '</a>';
		} else {
			the_field( 'rights_statement_other' );
		}
		echo '</p>
		</section>';
	}

	$grant_funders_statement = get_field( 'grant_funders_statement' );
	if ( $grant_funders_statement ) {
		echo '<section id="grant-funders-statement" class="meta">
		<h2>Grant Funders Statement</h2>
		<p>' . $grant_funders_statement . '</p>
		</section>';
	}
	?>
</aside>
