@component('mails/email')
   

	<p>Hello guys,</p><br/>


	<p>New user has been added.</p><br/>

	<p>Full Name: {{ $user->firstname }} {{ $user->firstname }}</p><br/>

    <p>Email:  {{ $user->email }}</p><br/>

    <p>Phone:  {{ $user->phone }}</p><br/>


	<p>Regards,</p>
	<p>Virtual Academy PH</p>

@endcomponent    

