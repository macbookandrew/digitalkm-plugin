</main>

<aside id="rights" class="sidebar right">
	<?php

	$type = $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'category', 'Type' );
	if ( $type ) {
		echo '<section id="type" class="meta">
			<h2>Type</h2>
			<p>' . $type . '</p>
		</section>';
	}

	$topics = $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'post_tag', 'Topics' );
	if ( $type ) {
		echo '<section id="topics" class="meta">
			<h2>Topics</h2>
			<p>' . $topics . '</p>
		</section>';
	}

	$subject = $DKM_Helper->get_artifact_tax_html( get_the_ID(), 'artifact_subject', 'Subject' );
	if ( $subject ) {
		echo '<section id="subject" class="meta">
			<h2>Subject</h2>
			<p>' . $subject . '</p>
		</section>';
	}

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
