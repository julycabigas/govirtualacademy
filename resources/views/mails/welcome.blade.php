@component('mails/email')
   

	<p>Hello {{ $firstname }},</p><br/>


	<p>Thank you for signing up with Virtual Academy PH.</p><br/>


	<p>This is Virtual Academy’s CEO personally reaching out to welcome you to our family. I am very much ecstatic.</p><br/>


	<p>Virtual Academy PH is a digital marketing tutorial website composed of highly skilled individuals living the core Filipino values. You will not experience dull moments while learning and earning with the mastery of our high quality tutorials. </p><br/>


	<p>Be one of us and become globally competitive.</p><br/>

	<p>Can’t wait to get started? Just click this link to help you set up. Check out what cool courses are waiting for you to unleashed.</p><br/>

	<p>Hit your dreams hard with Virtual Academy PH your POWER MOVE towards technology greatness.</p><br/>

    <p>Here's the link to the website:</p>

	<p><a href="{{ $url }}/login">{{ $url }}/login</a></p><br/>


	<p>Regards,</p>
	<p>Jurellie Catalan</p>

@endcomponent    

