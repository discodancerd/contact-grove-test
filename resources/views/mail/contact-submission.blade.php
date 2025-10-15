<div>
	A new contact has been submitted

	<p>From: {{ $submission->name, $submission->email }}</p>
	<p>Subject: {{ $submission->subject }}</p>
	<p>Message: {{ $submission->message }}</p>

	@if($submission->attachment !== null)
		<p>Attachment:</p>
	@endif
</div>