@component('mails/email')
    <p>Hey there,</p><br>
	<p>Somebody (hopefully you) requested a new password for the Virtual Academy PH account. No changes have been made to your account yet.</p>
	<br>
	<p>You can reset your password by clicking the link below:</p>
	<br>
	<p><a href="{{ $url }}/reset-password?token={{ $token->token }}" class="button">Reset</a></p>
	<br>
	<p>If you didn't make this request then you can safely ignore this email :)</p><br>

	<p>Regards,</p>
	<p>Virtual Academy PH Team</p>
	<br>

@endcomponent    

