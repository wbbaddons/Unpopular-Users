{if $user->annoyThisUser == 0}
	<li><a href="index.php?action=UserProfileSetAnnoy&amp;userID={@$userID}&amp;t={@SECURITY_TOKEN}{@SID_ARG_2ND}">{lang}wcf.user.profile.userprofilesetannoy{/lang}</a></li>
{else}
	<li><a href="index.php?action=UserProfileDeleteAnnoy&amp;userID={@$userID}&amp;t={@SECURITY_TOKEN}{@SID_ARG_2ND}">{lang}wcf.user.profile.userprofiledeleteannoy{/lang}</a></li>
{/if}