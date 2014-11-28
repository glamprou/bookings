<?php

require_once('Language.php');

class gr_el extends Language
{
    public function __construct()
    {
        parent::__construct();
    }

	protected function _LoadDates()
	{
		$dates = array();

		$dates['general_date'] = 'd/m/Y';
		$dates['general_datetime'] = 'd/m/Y H:i:s';
		$dates['schedule_daily'] = 'l, d/m/Y';
		$dates['reservation_email'] = 'd/m/Y @ G:i';
		$dates['res_popup'] = 'd/m/Y G:i';
		$dates['dashboard'] = 'l, d/m/Y G:i';
		$dates['period_time'] = "G:i";
		$dates['general_date_js'] = "dd/mm/yy";
		$dates['calendar_time'] = 'h:mmt';
		$dates['calendar_dates'] = 'M/d';

		$this->Dates = $dates;

        return $this->Dates;
	}




	protected function _LoadStrings()
    {
        $strings = array();

		$strings['ApplicationName'] = 'Ace Tennis Academy Booking';

		$strings['FirstName'] = 'Όνομα';
        $strings['LastName'] = 'Επίθετο';
        $strings['Timezone'] = 'Ζώνη ώρας';
        $strings['Edit'] = 'Επεξεργασία';
        $strings['Change'] = 'Αλλαγή';
        $strings['Rename'] = 'Μετονομασιά';
        $strings['Remove'] = 'Αφαίρεση';
        $strings['Delete'] = 'Διαγραφή';
        $strings['Update'] = 'Ενημέρωση';
        $strings['Cancel'] = 'Άκυρο';
        $strings['Add'] = 'Προσθήκη';
        $strings['Name'] = 'Όνομα';
        $strings['Yes'] = 'Ναι';
        $strings['No'] = 'Όχι';
        $strings['FirstNameRequired'] = 'Το Όνομα είναι υποχρεωτικό.';
        $strings['LastNameRequired'] = 'Το Επίθετο είναι υποχρεωτικό.';
        $strings['PwMustMatch'] = 'Η επαλήθευση του κωδικού δεν πρέπει να διαφέρει από τον κωδικό.';
        $strings['PwComplexity'] = 'Ο κωδικός πρέπει να αποτελείτε από τουλάχιστον 6 χαρακτήρες (προτείνετε συνδυασμός λατινικών γραμμάτων, συμβόλων και αριθμών).';
        $strings['ValidEmailRequired'] = 'Παρακαλώ εισάγεται ένα έγκυρο email.';
        $strings['UniqueEmailRequired'] = 'Αυτό το email υπάρχει ήδη.';
        $strings['UniqueUsernameRequired'] = 'Αυτό το όνομα χρήστη (user name) υπάρχει ήδη.';
        $strings['UserNameRequired'] = 'Το όνομα χρηστη (user name) είναι υποχρεωτικό.';
        $strings['CaptchaMustMatch'] = 'Παρακαλώ εισάγετε τα γράμματα του κωδικού ασφαλείας όπως τα βλέπετε στην εικόνα.';
        $strings['Today'] = 'Σήμερα';
        $strings['Week'] = 'Εβδομάδα';
        $strings['Month'] = 'Μήνας';
        $strings['BackToCalendar'] = 'Επιστροφή στο ημερολόγιο';
        $strings['BeginDate'] = 'Από';
        $strings['EndDate'] = 'Έως';
        $strings['Username'] = 'όνομα χρήστη';
        $strings['Password'] = 'συνθηματικό';
        $strings['PasswordConfirmation'] = 'Επαλήθευση Κωδικού';
        $strings['DefaultPage'] = 'Προεπιλεγμένη Αρχική';
        $strings['MyCalendar'] = 'Το Ημερολόγιο μου';
        $strings['ScheduleCalendar'] = 'Πρόγραμμα ημερολογίου';
        $strings['Registration'] = 'Εγγραφή';
        $strings['NoAnnouncements'] = 'Δεν υπάρχουν ανακοινώσεις';
        $strings['Announcements'] = 'Ανακοινώσεις';
        $strings['NoUpcomingReservations'] = 'Δεν έχετε επερχόμενες κρατήσεις';
        $strings['UpcomingReservations'] = 'Επερχόμενες κρατήσεις';
        $strings['ShowHide'] = 'Εμφάνιση/Απόκρυψη';
        $strings['Error'] = 'Σφάλμα';
        $strings['ReturnToPreviousPage'] = 'Επιστροφή στην προηγούμενη σελίδα';
        $strings['UnknownError'] = 'Άγνωστο σφάλμα';
        $strings['InsufficientPermissionsError'] = 'Δεν έχετε δικαιώμα πρόσβασης';
        $strings['MissingReservationResourceError'] = 'Δεν επιλέξατε γήπεδο';
        $strings['MissingReservationScheduleError'] = 'Δεν επιλέξατε πρόγραμμα';
        $strings['DoesNotRepeat'] = 'Δεν επαναλαμβάνεται';
        $strings['Daily'] = 'Ημερήσιο';
        $strings['Weekly'] = 'Εβδομαδιαίο';
        $strings['Monthly'] = 'Μηνιαίο';
        $strings['Yearly'] = 'Ετήσιο';
        $strings['RepeatPrompt'] = 'Επανάληψη';
        $strings['hours'] = 'ώρες';
        $strings['days'] = 'ημέρες';
        $strings['weeks'] = 'εβδομάδες';
        $strings['months'] = 'μήνες';
        $strings['years'] = 'χρόνια';
        $strings['day'] = 'ημέρα';
        $strings['week'] = 'εβδομάδα';
        $strings['month'] = 'μήνας';
        $strings['year'] = 'χρόνος';
        $strings['repeatDayOfMonth'] = 'ημέρα μήνα';
        $strings['repeatDayOfWeek'] = 'ημέρα εβδομάδας';
        $strings['RepeatUntilPrompt'] = 'Μέχρι';
        $strings['RepeatEveryPrompt'] = 'Κάθε';
        $strings['RepeatDaysPrompt'] = 'Ενεργό';
        $strings['CreateReservationHeading'] = 'Δημιουργία νέας κράτησης';
        $strings['EditReservationHeading'] = 'Επεξεργασία κράτησης %s';
        $strings['ViewReservationHeading'] = 'Προβολή κράτησης %s';
        $strings['ReservationErrors'] = 'Αλλαγή κράτησης';
        $strings['Create'] = 'Δημιουργία';
        $strings['ThisInstance'] = 'Only This Instance';
        $strings['AllInstances'] = 'All Instances';
        $strings['FutureInstances'] = 'Future Instances';
        $strings['Print'] = 'Εκτύπωση';
        $strings['ShowHideNavigation'] = 'Εμφάνιση/Απόκρυψη πλοήγησης';
        $strings['ReferenceNumber'] = 'Αριθμός αναφοράς';
        $strings['Tomorrow'] = 'Αύριο';
        $strings['LaterThisWeek'] = 'Αυτή την εβδομάδα';
        $strings['NextWeek'] = 'Την επόμενη εβδομάδα';
        $strings['SignOut'] = 'Έξοδος';
        $strings['LayoutDescription'] = 'Ξεκινάει %s, εμφανίζει %s ημέρες κάθε φορά';
        $strings['AllResources'] = 'Όλα τα γήπεδα';
        $strings['TakeOffline'] = 'Αναίρεση ανάρτησης';
        $strings['BringOnline'] = 'Ανάρτηση';
        $strings['AddImage'] = 'Προσθήκη εικόνας';
        $strings['NoImage'] = 'Δεν υπάρχει εικόνα';
        $strings['Move'] = 'Μετακίνηση';
        $strings['AppearsOn'] = 'Εμφανίζεται %s';
        $strings['Location'] = 'Τοποθεσία';
        $strings['NoLocationLabel'] = '(δεν ορίστηκε τοποθεσία)';
        $strings['Contact'] = 'Επικοινωνία';
        $strings['NoContactLabel'] = '(δεν υπάρχουν στοιχεία επικοινωνίας)';
        $strings['Description'] = 'Περιγραφή';
        $strings['NoDescriptionLabel'] = '(δεν υπάρχει περιγραφή)';
        $strings['Notes'] = 'Σημειώσεις';
        $strings['NoNotesLabel'] = '(δεν υπάρχουν σημειώσεις)';
        $strings['NoTitleLabel'] = '(δεν υπάρχει τίτλος)';
        $strings['UsageConfiguration'] = 'Χρήση ρυθμίσεων';
        $strings['ChangeConfiguration'] = 'Αλλαγή ρυθμίσεων';
        $strings['ResourceMinLength'] = 'Η κάθε κράτηση πρέπει να διαρκεί τουλάχιστον %s';
        $strings['ResourceMinLengthNone'] = 'Δεν υπάρχει ελάχιστη διάρκεια κράτησης';
        $strings['ResourceMaxLength'] = 'Η κάθε κράτηση δεν μπορεί να διαρκεί πάνω από %s';
        $strings['ResourceMaxLengthNone'] = 'Δεν υπάρχει μέγιστη διάρκεια κράτησης';
        $strings['ResourceRequiresApproval'] = 'Η κάθε κράτηση πρέπει να εγκριθεί';
        $strings['ResourceRequiresApprovalNone'] = 'Οι κρατήσεις δεν χρειάζονται έγκριση';
        $strings['ResourcePermissionAutoGranted'] = 'Η πρόσβασης δίνεται αυτόματα';
        $strings['ResourcePermissionNotAutoGranted'] = 'Η πρόσβαση δεν δίνεται αυτόματα';
        $strings['ResourceMinNotice'] = 'Η κάθε κράτηση πρέπει να γίνει τουλάχιστον %s πριν την ώρα έναρξης';
        $strings['ResourceMinNoticeNone'] = 'Η κάθε κράτηση μπορεί να πραγματοποιηθεί μέχρι και την τωρινή ώρα';
        $strings['ResourceMaxNotice'] = 'Η κάθε κράτηση δεν πρέπει να λήγει μετά από %s';
        $strings['ResourceMaxNoticeNone'] = 'Η κάθε κράτηση μπορεί να τελειώνει οποτεδήποτε';
        $strings['ResourceAllowMultiDay'] = 'Η κάθε κράτηση μπορεί να συνεχίσει και την επόμενη ημέρα';
        $strings['ResourceNotAllowMultiDay'] = 'Η κράτηση δεν μπορεί να συνεχιστεί και την επόμενη ημέρα';
        $strings['ResourceCapacity'] = 'Αυτό το γήπεδο χωράει %s άτομα';
        $strings['ResourceCapacityNone'] = 'Αυτό το γήπεδο είναι απεριόριστης χωριτηκότητας';
        $strings['AddNewResource'] = 'Προσθήκη νέου γηπέδου';
        $strings['AddNewUser'] = 'Προσθήκε νέου μέλους';
        $strings['AddUser'] = 'Προσθήκη μέλους';
        $strings['Schedule'] = 'Πρόγραμμα';
        $strings['AddResource'] = 'Προσθήκη γηπέδου';
        $strings['Capacity'] = 'Χωρητικότητα';
        $strings['Access'] = 'Πρόσβαση';
        $strings['Duration'] = 'Διάρκεια';
        $strings['Active'] = 'Ενεργό';
        $strings['Inactive'] = 'Ανενεργό';
        $strings['ResetPassword'] = 'Νέο συνθηματικό';
        $strings['LastLogin'] = 'Τελευταία είσοδος';
        $strings['Search'] = 'Αναζήτηση';
        $strings['ResourcePermissions'] = 'Δικαιώματα γηπέδου';
        $strings['Reservations'] = 'Κρατήσεις';
        $strings['Groups'] = 'Ομάδα';
        $strings['ResetPassword'] = 'Νέο συνθηματικό';
        $strings['AllUsers'] = 'Όλα τα μέλη';
        $strings['AllGroups'] = 'Όλες οι ομάδες';
        $strings['AllSchedules'] = 'Συνολικά';
        $strings['UsernameOrEmail'] = 'όνομα χρήστη';
        $strings['Members'] = 'Μέλη';
        $strings['QuickSlotCreation'] = 'Δημιουργία πλαισίων κάθε %s λεπτά μεταξύ %s και %s';
        $strings['ApplyUpdatesTo'] = 'ΕφαρμογήΕνημερώσεωνΣε';
        $strings['CancelParticipation'] = 'Ακύρωση συμμετοχής';
				$strings['participateInOpenReservation'] = 'Δήλωση συμμετοχής';
        $strings['Attending'] = 'Παρακολούθηση';
        $strings['QuotaConfiguration'] = 'Στο %s για %s για χρήστες %s περιορισμός %s %s ανά %s';
        $strings['reservations'] = 'κρατήσεις';
        $strings['ChangeCalendar'] = 'Αλλαγή Ημερολογίου';
        $strings['AddQuota'] = 'Προσθήκη περιορισμών';
        $strings['FindUser'] = 'Εύρεση μέλους';
        $strings['Created'] = 'Δημιουργήθηκε';
        $strings['LastModified'] = 'Τελευταία τροποποίηση';
        $strings['GroupName'] = 'Όνομα ομάδας';
        $strings['GroupMembers'] = 'Μέλη ομάδας';
        $strings['GroupRoles'] = 'Ρόλος ομάδας';
        $strings['GroupAdmin'] = 'Ομάδα Διαχειριστών';
        $strings['Actions'] = 'Ενέργειες';
        $strings['CurrentPassword'] = 'Τρέχον συνθηματικό';
        $strings['NewPassword'] = 'Νέο συνθηματικό';
        $strings['InvalidPassword'] = 'Τρέχον συνθηματικό δεν είναι έγκυρο';
        $strings['PasswordChangedSuccessfully'] = 'Το συνθηματικό σας άλλαξε επιτυχώς';
        $strings['SignedInAs'] = 'Έχετε συνδεθεί σαν';
        $strings['NotSignedIn'] = 'Δεν έχετε συνδεθεί';
        $strings['ReservationTitle'] = 'Τίτλος κράτησης';
        $strings['ReservationDescription'] = 'Περιγραφή κράτησης';
        $strings['ResourceList'] = 'Γήπεδο προς κράτηση';
        $strings['Accessories'] = 'Αξεσουάρ';
        $strings['Add'] = 'Προσθήκη';
        $strings['ParticipantList'] = 'Συμμετέχοντες';
        $strings['InvitationList'] = 'Προσκεκλημένοι';
        $strings['AccessoryName'] = 'Όνομα αξεσουάρ';
        $strings['QuantityAvailable'] = 'Ποσότητα διαθέσιμη';
        $strings['Resources'] = 'Γήπεδα';
        $strings['Participants'] = 'Συμμετέχοντες';
        $strings['User'] = 'Μέλος';
        $strings['Resource'] = 'Γήπεδο';
        $strings['Status'] = 'Κατάσταση';
        $strings['Approve'] = 'Έγκριση';
        $strings['Page'] = 'Σελίδα';
        $strings['Rows'] = 'Γραμμές';
        $strings['Unlimited'] = 'Απεριόριστα';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Email';
        $strings['Phone'] = 'Κινητό';
        $strings['Organization'] = 'Εργασία';
        $strings['Position'] = 'Περιγραφή';
        $strings['Language'] = 'Γλώσσα';
        $strings['Permissions'] = 'Δικαιώματα';
        $strings['Reset'] = 'Επαναφορά';
        $strings['FindGroup'] = 'Εύρεση ομάδας';
        $strings['Manage'] = 'Διαχείριση';
        $strings['None'] = 'Κενό';
        $strings['None2'] = 'Συγκεντρωτικά';
        $strings['AddToOutlook'] = 'Προσθήκη στο Outlook';
        $strings['Done'] = 'Αποθήκευση';
        $strings['RememberMe'] = 'Να με θυμάσαι';
        $strings['FirstTimeUser?'] = 'Νέος χρήστης;';
        $strings['CreateAnAccount'] = 'εγγραφή';
        $strings['ViewSchedule'] = 'Προβολή προγράμματος';
        $strings['ForgotMyPassword'] = 'υπενθύμιση κωδικού';
        $strings['YouWillBeEmailedANewPassword'] = 'Θα λάβατε στο email που έχει δηλωθεί ένα νέο συνθηματικό';
        $strings['Close'] = 'Κλείσιμο';
        $strings['ExportToCSV'] = 'Εξαγωγή σε CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Έπεξεργασία';
        $strings['Login'] = 'Είσοδος';
        $strings['AdditionalInformation'] = 'Πρόσθετες πληροφορίες';
        $strings['AllFieldsAreRequired'] = 'όλα τα πεδία είναι υποχρεωτικά';
        $strings['Optional'] = 'προαιρετικά';
        $strings['YourProfileWasUpdated'] = 'Το προφίλ σας ενημερώθηκε επιτυχώς';
        $strings['YourSettingsWereUpdated'] = 'Οι ρυθμίσεις σας ενημερώθηκαν επιτυχώς';
        $strings['Register'] = 'Εγγραφή';
        $strings['SecurityCode'] = 'Κωδικός ασφαλείας';
        $strings['ReservationCreatedPreference'] = 'Όταν κάνω μια κράτηση ή γίνει κράτηση εκ μέρους μου';
        $strings['ReservationUpdatedPreference'] = 'Όταν ενημερώσω μία κράτηση ή ενημερωθεί εκ μέρους μου';
        $strings['ReservationDeletedPreference'] = 'Όταν ακυρώσω μία κράτηση ή ακυρωθεί εκ μέρους μου';
        $strings['ReservationApprovalPreference'] = 'Όταν εγκριθεί μία κράτηση';
        $strings['PreferenceSendEmail'] = 'Να σταλεί email';
        $strings['PreferenceNoEmail'] = 'Να μην ενημερώνομαι';
        $strings['ReservationCreated'] = 'Η κράτηση έγινε με επιτυχία!';
        $strings['ReservationUpdated'] = 'Η κράτηση ενημερώθηκε με επιτυχία!';
        $strings['ReservationRemoved'] = 'Η κράτηση ακυρώθηκε';
        $strings['YourReferenceNumber'] = 'Ο κωδικός της κράτηση είναι %s';
        $strings['UpdatingReservation'] = 'Ενημερώνετε η κράτηση';
        $strings['ChangeUser'] = 'Αλλαγή μέλους';
        $strings['MoreResources'] = 'Γήπεδα';
        $strings['ReservationLength'] = 'Διάρκεια κράτησης';
        $strings['ParticipantList'] = 'Συμμετέχοντες';
        $strings['AddParticipants'] = 'Προσθήκη συμμετέχοντα';
        $strings['InviteOthers'] = 'Προσκαλέστε άλλους';
        $strings['AddResources'] = 'Προσθήκη γηπέδων';
        $strings['AddAccessories'] = 'Προσθήκη αξεσουάρ';
        $strings['Accessory'] = 'Αξεσουάρ';
        $strings['QuantityRequested'] = 'Ζητήθηκε ποσότητα';
        $strings['CreatingReservation'] = 'Δημιουργία κράτησης';
        $strings['UpdatingReservation'] = 'Ενημέρωση κράτησης';
        $strings['DeleteWarning'] = 'Αυτή η διαγραφή είναι μη αναστρέψιμη!';
        $strings['DeleteAccessoryWarning'] = 'Προσοχή, θα διαγραφεί από όλες τις κρατήσεις.';
        $strings['AddAccessory'] = 'Προσθήκη αξεσουάρ';
        $strings['AddBlackout'] = 'Προσθήκη Blackout';
        $strings['AllResourcesOn'] = 'Όλα τα γήπεδα ενεργά';
        $strings['Reason'] = 'Αιτία';
        $strings['BlackoutShowMe'] = 'Εμφάνιση κρατήσεων που παρεμβάλλονται';
        $strings['BlackoutDeleteConflicts'] = 'Διαγραφή κρατήσεων που παρεμβάλλονται';
        $strings['Filter'] = 'Φίλτρο';
        $strings['Between'] = 'Μεταξύ';
        $strings['CreatedBy'] = 'Δημιουργήθηκε από';
        $strings['BlackoutCreated'] = 'Δημοιουργήθηκε Blackout!';
        $strings['BlackoutNotCreated'] = 'Δεν μπόρεσε να δημιουργηθεί Blackout!';
        $strings['BlackoutConflicts'] = 'Παρεμβάλλονται άλλα Blackout';
        $strings['ReservationConflicts'] = 'Παρεμβάλλονται κρατήσεις';
        $strings['UsersInGroup'] = 'Μέλη στην ομάδα';
        $strings['Browse'] = 'Περιήγηση';
        $strings['DeleteGroupWarning'] = 'Διαγραφή αυτής της ομάδας θα διαγράψει και όλα τα συνδεόμενα δικαιώματα γηπέδων. Μέλη της ομάδας δεν θα έχουν πρόσβαση σε γήπεδα.';
        $strings['WhatRolesApplyToThisGroup'] = 'Ποιοι ρόλοι διακρίνονται στην ομάδα?';
        $strings['WhoCanManageThisGroup'] = 'Ποιος μπορεί να διαχειριστεί την ομάδα?';
		$strings['WhoCanManageThisSchedule'] = 'Ποιος μπορεί να διαχειριστεί αυτό το πρόγραμμα?';
        $strings['AddGroup'] = 'Προσθήκη ομάδας';
        $strings['AllQuotas'] = 'Όλοι οι περιορισμοί';
        $strings['QuotaReminder'] = 'Υπενθύμιση: Οι περιορισμοί επιβάλλονται με βάση την ζώνη ώρας του προγράμματος.';
        $strings['AllReservations'] = 'Όλες οι κρατήσεις';
				$strings['Payments'] = 'Πληρωμές';
				$strings['PaidReservations'] = 'Πληρωμένες';
				$strings['UnpaidReservations'] = 'Απλήρωτες';
				$strings['EmptyPaidReservations'] = 'Κενό';
        $strings['ActiveReservations'] = 'Ενεργές κρατήσεις';
        $strings['Approving'] = 'Εγκρίνετε';
        $strings['MoveToSchedule'] = 'Μετακίνηση στο πρόγραμμα';
        $strings['DeleteResourceWarning'] = 'Διαγραφή του γηπέδου συνεπάγεται διαγραφή όλων των συμβαλλόμενων δεδομένων, συμπεριλαμβανομένου:';
        $strings['DeleteResourceWarningReservations'] = 'όλες τις παλιές, τρέχοντες και μελλοντικές κρατήσεις συνδεδεμένες με αυτό';
        $strings['DeleteResourceWarningPermissions'] = 'όλες τις αναθέσει δικαιωμάτων';
        $strings['DeleteResourceWarningReassign'] = 'Παρακαλώ επανακαταχωρήστε ότι δεν θέλετε να διαγραφεί πριν προχωρήσετε';
        $strings['ScheduleLayout'] = 'Σχέδιο (ζώνη ώρας %s)';
        $strings['ReservableTimeSlots'] = 'Πλαίσια κρατήσεων';
        $strings['BlockedTimeSlots'] = 'Μπλοκαρισμένα πλαίσια κρατήσεων';
        $strings['ThisIsTheDefaultSchedule'] = 'Προεπιλεγμένο πρόγραμμα';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Δεν μπορεί να διαγραφεί το προεπιλεγμένο πρόγραμμα';
        $strings['MakeDefault'] = 'Ορισμός προεπιλεγμένου';
        $strings['BringDown'] = 'Κατέβασε';
        $strings['ChangeLayout'] = 'Αλλαγή σχεδίου';
        $strings['AddSchedule'] = 'Προσθήκη προγράμματος';
        $strings['StartsOn'] = 'Ξεκινάει';
        $strings['NumberOfDaysVisible'] = 'Ορατός αριθμός ημερών';
        $strings['UseSameLayoutAs'] = 'Χρήση ίδου σχεδίου με';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Προαιρετική ετικέτα';
        $strings['LayoutInstructions'] = 'Εισάγετε ένα πλαίσιο ανά γραμμή. Πρέπει να κανθοριστούν πλαίσια γιά ολόκληρο το 24ωρο.';
        $strings['AddUser'] = 'Προσθήκη μέλους';
        $strings['UserPermissionInfo'] = 'Η πρόσβαση στο γήπεδο μπορεί να διαφέρει ανάλογα με το μέλος - χρήστη, δικαιώματα και ρυθμίσεις.';
        $strings['DeleteUserWarning'] = 'Η διαγραφή του συγκεκριμένου μέλους θα διαγράψει και όλες τις τρέχοντες, μελλοντικές και παλιές κρατήσεις.';
        $strings['AddAnnouncement'] = 'Προσθήκη ανακοίνωσης';
        $strings['Announcement'] = 'Ανακοίνωση';
        $strings['Priority'] = 'Προτεραιότητα';
        $strings['Important_announc'] = 'Σημαντικό';
        $strings['Reservable'] = 'Διαθέσιμα';
        $strings['Unreservable'] = 'Μη διαθέσιμα';
        $strings['Reserved'] = 'Κλεισμένα';
        $strings['Open'] = 'Αναμονή παίκτη';
        $strings['MyReservation'] = 'Κρατήσεις μου';
        $strings['Pending'] = 'Εκκρεμής';
        $strings['Past'] = 'Παλαιά';
        $strings['Restricted'] = 'Περιορισμένα';
        $strings['ViewAll'] = 'Προβολή όλων';
        $strings['MoveResourcesAndReservations'] = 'Μετακίνηση γηπέδων και κρατήσεων σε';
        $strings['TurnOffSubscription'] = 'Απενεργοποίηση συνδρομής';
        $strings['TurnOnSubscription'] = 'Να υπάρχει συνδρομή';
        $strings['SubscribeToCalendar'] = 'Εγγραφή';
        $strings['SubscriptionsAreDisabled'] = 'Ο διαχειριστής απενεργοποίηση την συνδρομή';
        $strings['NoResourceAdministratorLabel'] = '(No court Administrator)';
        $strings['WhoCanManageThisResource'] = 'Ποιος μπορεί να διαχειριστεί αυτό το γήπεδο;';
        $strings['ResourceAdministrator'] = 'Court Administrator';
        $strings['Private'] = 'Προσωπικό';
        $strings['Accept'] = 'Αποδοχή';
        $strings['Decline'] = 'Απόρριψη';
        $strings['ShowFullWeek'] = 'Εμφάνισε εβδομάδα';
        $strings['CustomAttributes'] = 'Επιπλέον επιλογές';
        $strings['AddAttribute'] = 'Προσθήκη επιλογής';
        $strings['EditAttribute'] = 'Ενημέρωση επιλογής';
        $strings['DisplayLabel'] = 'Λεζάντα εμφάνισης';
        $strings['Type'] = 'Τύπος';
        $strings['Required'] = 'Υποχρεωτικό';
        $strings['ValidationExpression'] = 'Validation Expression';
        $strings['PossibleValues'] = 'Δυνατές τιμές';
        $strings['SingleLineTextbox'] = 'Κείμενο μιας γραμμής';
        $strings['MultiLineTextbox'] = 'Κείμενο πολλαπλών γραμμών';
        $strings['Checkbox'] = 'Επιλογή';
        $strings['SelectList'] = 'Επιλογή λίστας';
        $strings['CommaSeparated'] = 'διαχωρισμένα με κόμματα';
        $strings['Category'] = 'Κατηγορία';
        $strings['CategoryReservation'] = 'Κράτηση';
        $strings['CategoryGroup'] = 'Ομάδα';
        $strings['SortOrder'] = 'Με σειρά';
        $strings['Title'] = 'Τίτλος';
        $strings['AdditionalAttributes'] = 'Επιπλέον επιλογές';
        $strings['True'] = 'True';
        $strings['False'] = 'False';
        $strings['ForgotPasswordEmailSent'] = 'Στάλθηκε ένα email στην διεύθυνση που μας έχετε δώσει με οδηγίες νέου ορισμού του συνθηματικού σας';
        $strings['ActivationEmailSent'] = 'Θα λάβετε σύντομα ένα email εγγραφής.';
        $strings['AccountActivationError'] = 'Ζητούμε συγνώμη δεν μπορούμε να ενεργοποιήσουμε τον λογαριασμό σας.';
        $strings['Attachments'] = 'επισυναπτόμενα';
        $strings['AttachFile'] = 'επισύναψη αρχείου';
        $strings['Maximum'] = 'μέγιστο';
        $strings['NoScheduleAdministratorLabel'] = 'Δεν υπάρχει Administrator Προγράμματος';
        $strings['ScheduleAdministrator'] = 'Administrator Προγράμματος';
        $strings['Total'] = 'Σύνολο';
        $strings['QuantityReserved'] = 'Κρατημένη ποσότητα';
        $strings['AllAccessories'] = 'Όλα τα αξεσουάρ';
        $strings['GetReport'] = 'Αναζήτηση';
        $strings['NoResultsFound'] = 'Δεν βρέθηκαν αποτελέσματα';
        $strings['SaveThisReport'] = 'Αποθήκευση αναζήτησης';
        $strings['ReportSaved'] = 'Αποθηκεύτηκε η αναζήτηση!';
        $strings['EmailReport'] = 'Αποστολή';
        $strings['ReportSent'] = 'Απεστάλη!';
        $strings['RunReport'] = 'Προβολή';
        $strings['NoSavedReports'] = 'Δεν έχετε αποθηκεύσει καμία αναζήτηση.';
        $strings['CurrentWeek'] = 'Τρέχ. εβδομάδα';
        $strings['CurrentMonth'] = 'Τρέχον μήνας';
        $strings['AllTime'] = 'Όλες';
        $strings['FilterBy'] = 'Φίλτρο';
        $strings['Select'] = 'Επιλογή';
        $strings['List'] = 'Λίστα';
        $strings['TotalTime'] = 'Συνολ. Χρόνος';
        $strings['Count'] = 'Κρατήσεις';
        $strings['Usage'] = 'Χρήση';
        $strings['AggregateBy'] = 'Εμφάνιση >';
        $strings['Range'] = 'Ημερομηνία';
        $strings['Choose'] = 'Choose';
        $strings['All'] = 'All';
        $strings['ViewAsChart'] = 'Γράφημα';
        $strings['ReservedResources'] = 'Κλεισμένα γήπεδα';
        $strings['ReservedAccessories'] = 'Κλεισμένα αξεσουάρ';
        $strings['ResourceUsageTimeBooked'] = 'Χρήση Γηπέδων βάση χρόνου';
        $strings['ResourceUsageReservationCount'] = 'Χρήση Γηπέδων βάση κρατήσεων';
        $strings['Top20UsersTimeBooked'] = 'Top 20 χρήστες βάση χρόνου';
        $strings['Top20UsersReservationCount'] = 'Top 20 χρήστες βάση κρατήσεων';
        $strings['ConfigurationUpdated'] = 'The configuration file was updated';
        $strings['ConfigurationUiNotEnabled'] = 'This page cannot be accessed because $conf[\'settings\'][\'pages\'][\'enable.configuration\'] is set to false or missing.';
        $strings['ConfigurationFileNotWritable'] = 'The config file is not writable. Please check the permissions of this file and try again.';
        $strings['ConfigurationUpdateHelp'] = 'Refer to the Configuration section of the <a target=_blank href=%s>Help File</a> for documentation on these settings.';
        $strings['GeneralConfigSettings'] = 'Ρυθμίσεις';
        $strings['UseSameLayoutForAllDays'] = 'Χρήση ίδιας φόρμας για όλες τις ημέρες';
        $strings['LayoutVariesByDay'] = 'Η φόρμα διαφέρει ανά ημέρα';
        $strings['ManageReminders'] = 'Υπενθυμίσεις';
        $strings['ReminderUser'] = 'User ID';
        $strings['ReminderMessage'] = 'Μήνυμα';
        $strings['ReminderAddress'] = 'Διεύθυνση';
        $strings['ReminderSendtime'] = 'Ώρα αποστολής';
        $strings['ReminderRefNumber'] = 'Αριθμός αναφοράς κράτησης';
        $strings['ReminderSendtimeDate'] = 'Ημερομηνία υπενθύμισης';
        $strings['ReminderSendtimeTime'] = 'Ώρα υπενθύμισης(ΩΩ:ΛΛ)';
        $strings['ReminderSendtimeAMPM'] = 'ΠΜ / ΜΜ';
        $strings['AddReminder'] = 'Προσθήκη υπενθύμισης';
        $strings['DeleteReminderWarning'] = 'Είστε σίγουροι;';
        $strings['NoReminders'] = 'Δεν υπάρχουν επερχόμενες υπενθυμίσεις.';
        $strings['Reminders'] = 'Υπενθυμίσεις';
        $strings['SendReminder'] = 'Αποστολή υπενθύμισης';
        $strings['minutes'] = 'λεπτά';
        $strings['hours'] = 'ώρες';
        $strings['days'] = 'ημέρες';
        $strings['ReminderBeforeStart'] = 'πριν την έναρξη';
        $strings['ReminderBeforeEnd'] = 'πριν την λήξη';
        $strings['Logo'] = 'Λογότυπο';
        $strings['CssFile'] = 'Αρχείο CSS';
        $strings['ThemeUploadSuccess'] = 'Your changes have been saved. Refresh the page for changes to take effect.';
        $strings['MakeDefaultSchedule'] = 'Όρισμός ως προεπιλεγμένο πρόγραμμα';
        $strings['DefaultScheduleSet'] = 'Το προεπιλεγμένο σας πρόγραμμα';
        $strings['FlipSchedule'] = 'Αλλαγή διάταξης';
        $strings['Next'] = 'Επόμενο';
        $strings['Success'] = 'Επιτυχία';
        $strings['Participant'] = 'Συμμετοχή';
        $strings['kairos'] = 'Καιρός';
        $strings['aeras'] = 'Αέρας';
        $strings['unplayable_courts'] = 'Τα γήπεδα δεν παίζονται';
        $strings['save_weather'] = 'Αποθήκευση καιρού';
        $strings['save_hours'] = 'Αποθήκευση ωρών';
        $strings['deleteedittimebeforeres'] = 'Ελάχιστος χρόνος για διαγραφή ή τροποποίηση πρίν την έναρξη της κράτησης';
        $strings['freeofcharge'] = 'Χωρίς Χρέωση';
        $strings['Level'] = 'Επίπεδο';
        $strings['ParticipantsNeeded'] = 'Ψάχνω παίκτη';
        $strings['Training'] = 'Προπόνηση';
        $strings['RankingTable'] = 'Πίνακας Κατάταξης';
        $strings['noRankingTables'] = 'Δεν υπάρχουν πίνακες κατάταξης';
        $strings['chooseCallPrompt'] = 'Επιλογή αγώνα';
        $strings['chooseNoCall'] = 'Δεν είναι αγώνας κατάταξης';
        $strings['Return'] = 'Επιστροφή';
        $strings['RankingAdmin'] = 'Διαχείριση';
        $strings['RankingVars'] = 'Αρχικοποίηση';
        $strings['active_reservations'] = 'ενεργές κρατήσεις';
        $strings['per_day'] = 'ανά ημέρα';
        $strings['per_week'] = 'ανά εβδομάδα';
        $strings['per_month'] = 'ανά μήνα';
        $strings['isTrainingOrTour'] = 'Προπόνηση / Τουρνουά';
        $strings['isTrainingOrTourTitle'] = 'Τα παιχνίδια προπόνησης ή τουρνουά δεν υπολογίζονται στους περιορισμούς κρατήσεων';
        $strings['isOpenRes'] = 'Ψάχνω παίκτη';
        $strings['telephone'] = 'Τα παιχνίδια προπόνησης ή τουρνουά δεν υπολογίζονται στους περιορισμούς κρατήσεων';
        $strings['games'] = 'Αγ. κατάταξης';
        $strings['openResLabel'] = 'Ψάχνει παίκτη';
        $strings['coaches'] = 'Προπονητές';
        $strings['guests'] = 'Επισκέπτες';
        $strings['cancelTraining'] = 'Ακύρωση προπόνησης';
        $strings['cancelTrainingSendSms'] = 'Αποστολή SMS στους συμμετέχοντες';
        $strings['cancelTrainingDueToWeather'] = 'Ακύρωση λόγω καιρού';
        $strings['cancelTrainingDueToSickness'] = 'Ακύρωση λόγω ασθένειας';
        $strings['cancelTrainingDueToMatch'] = 'Ακύρωση λόγω αγώνα';
        $strings['cancelTrainingDueToOther'] = 'Άλλο';
        $strings['ViewRanking'] = 'Προβολή κατάταξης';
        $strings['ΑcceptExceededQuota'] = 'Συνέχεια';
        $strings['CancelExceededQuota'] = 'Ακύρωση';
        $strings['Trainings'] = 'Προπονήσεις';
        // End Strings

        // Errors
        $strings['LoginError'] = 'Λάθος όνομα χρήστη ή συνθηματικού';
        $strings['ReservationFailed'] = 'Η κράτηση δεν μπόρεσε να πραγματοποιηθεί';
        $strings['MinNoticeError'] = 'Η κράτηση απαιτεί να γίνει έγκαιρα. Η πιο κοντινή κράτηση που μπορεί να γίνει είναι %s.';
        $strings['MaxNoticeError'] = 'Η κράτηση δεν μπορεί να γίνει διότι υπερβαίνει το άνω όριο μελλοντικών κρατήσεων. Μπορείτε να κάνετε κράτηση το αργότερο για τις %s.';
        $strings['MinDurationError'] = 'Η κράτηση θα πρέπει να διαρκεί τουλάχιστον %s.';
        $strings['MaxDurationError'] = 'Η κράτηση δεν μπορεί να διαρκεί πάνω από %s.';
        $strings['ConflictingAccessoryDates'] = 'Δεν υπάρχουν διαθέσιμα τα παρακάτω αξεσουάρ:';
        $strings['NoResourcePermission'] = 'Δεν έχετε τα απαραίτητα δικαιώματα για να κλείσετε ένα ή περισσότερα από τα ζητούμενα γήπεδα';
        $strings['ConflictingReservationDates'] = 'Υπάρχουν παρεμβαλλόμενες κρατήσεις στις παρακάτω ημερομηνίες:';
        $strings['StartDateBeforeEndDateRule'] = 'Η έναρξη πρέπει να είναι πριν την λήξη';
        $strings['StartIsInPast'] = 'Η έναρξη δεν μπορεί να είναι στο παρελθόν';
        $strings['EmailDisabled'] = 'Ο διαχειριστής έχει παενεργοποιήσει τις ειδοποιήσεις μέσω email';
        $strings['ValidLayoutRequired'] = 'Πρέπει να κανθοριστούν πλαίσια γιά ολόκληρο το 24ωρο.';
        $strings['CustomAttributeErrors'] = 'Υπάρχει πρόβλημα με τις επιπλέον επιλογές που έχετε εισάγει:';
        $strings['CustomAttributeRequired'] = '%s είναι υποχρεωτικό πεδίο';
        $strings['CustomAttributeInvalid'] = 'Η τιμή που δώσατε στο %s δεν είναι αποδεκτή';
        $strings['AttachmentLoadingError'] = 'Ζητούμε συγνώμη υπήρξε πρόβλημα στην φόρτωση του αρχείου.';
        $strings['InvalidAttachmentExtension'] = 'Μπορείτε να ανεβάσετε μόνο τα εξής αρχεία: %s';
		$strings['InvalidStartSlot'] = 'Η συγκεκριμένη ημερομηνία και ώρα έναρξης δεν είναι έγκυρη.';
		$strings['InvalidEndSlot'] = 'Η συγκεκριμένη ημερομηνία και ώρα λήξης δεν είναι έγκυρη.';
		$strings['MaxParticipantsError'] = '%s, υποστηρίζεται μόνο %s επιπλέον συμμετέχοντας.';
		$strings['AtLeastOneParticipant'] = 'Παρακαλώ εισάγετε τουλάχιστον έναν συμμετέχοντα!';
		$strings['AtLeastOneParticipantNoOpen_part1'] = 'Η αναζήτηση παίκτη επιτρέπεται να γίνει τουλάχιστον ';
		$strings['AtLeastOneParticipantNoOpen_part2'] = ' ώρες πρίν την έναρξη!';
		$strings['ReservationCriticalError'] = 'Υπήρξε κάποιο απρόσμενο πρόβλημα με την αποθήκευση της κράτησης. Εάν συνεχίσει και υπάρχει πρόβλημα παρακαλώ επικοινωνήστε με την γραμματεία, ευχαριστώ.';
		$strings['InvalidStartReminderTime'] = 'Η ώρα έναρξης της υπενθύμισης δεν είναι έγκυρη.';
		$strings['InvalidEndReminderTime'] = 'Η ώρα λήξης της υπενθύμισης δεν είναι έγκυρη.';
		$strings['tooSoonToEditOrDeleteReservation'] = 'Η τροποποίηση ή διαγραφή μιας κράτησης δεν είναι εφικτή {time_var} ώρες πριν την έναρξή της. Για οποιαδήποτε απορία παρακαλώ επικοινωνήστε με την γραμματεία, ευχαριστώ.';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Δημιουργία κράτησης';
        $strings['EditReservation'] = 'Επεξεργαδία κράτησης';
        $strings['LogIn'] = 'είσοδος';
        $strings['ManageReservations'] = 'Κρατήσεις';
        $strings['AwaitingActivation'] = 'Αναμονή ενεργοποίησης';
        $strings['PendingApproval'] = 'Αναμονή έγκρισης';
        $strings['ManageSchedules'] = 'Πρόγραμμα';
        $strings['ManageResources'] = 'Γήπεδα';
        $strings['ManageAccessories'] = 'Αξεσουάρ';
        $strings['ManageUsers'] = 'Μέλη';
        $strings['ManageGroups'] = 'Ομάδες';
        $strings['ManageQuotas'] = 'Περιορισμοί';
        $strings['ManageBlackouts'] = 'Blackout';
        $strings['MyDashboard'] = 'Πίνακας';
        $strings['ServerSettings'] = 'Ρυθμίσεις Server';
        $strings['Dashboard'] = 'Πίνακας';
        $strings['Help'] = 'Βοήθεια';
		$strings['Administration'] = 'Administration';
		$strings['About'] = 'About';
        $strings['Bookings'] = 'Κρατήσεις';
        $strings['Schedule'] = 'Πρόγραμμα';
        $strings['Reservations'] = 'Κρατήσεις';
        $strings['Account'] = 'Λογαριασμός';
        $strings['EditProfile'] = 'Επεξεργασία Προφίλ';
        $strings['FindAnOpening'] = 'Εύρεση';
        $strings['OpenInvitations'] = 'Ανοιχτές προσκλήσεις';
        $strings['MyCalendar'] = 'Ημερολόγιο';
        $strings['ResourceCalendar'] = 'Προβολή γηπέδων';
        $strings['Reservation'] = 'Νέα κράτηση';
        $strings['Install'] = 'Εγκατάσταση';
        $strings['ChangePassword'] = 'Συνθηματικό';
        $strings['MyAccount'] = 'Ο λογαριασμός μου';
        $strings['Profile'] = 'Προφίλ';
        $strings['PointSystem'] = 'Βαθμολογία';
        $strings['ApplicationManagement'] = 'Διαχείριση Εφαρμογής';
        $strings['ForgotPassword'] = 'Ξέχασα το συνθηματικό';
        $strings['NotificationPreferences'] = 'Ρυθμίσεις ενημερώσεων';
        $strings['ManageAnnouncements'] = 'Ανακοινώσεις';
        $strings['Responsibilities'] = 'Υπευθυνότητες';
        $strings['GroupReservations'] = 'Κρατήσεις ομάδων';
        $strings['ResourceReservations'] = 'Κρατήσεις γηπέδων';
        $strings['Customization'] = 'Παραμετροποίηση';
        $strings['Attributes'] = 'Επιλογές';
		$strings['AccountActivation'] = 'Ενεργοποίηση λογαριασμού';
		$strings['ScheduleReservations'] = 'Schedule Reservations';
		$strings['Reports'] = 'Στατιστικά';
		$strings['GenerateReport'] = 'Αναζήτηση';
		$strings['MySavedReports'] = 'Αποθηκευμένες';
		$strings['CommonReports'] = 'Έτοιμα φίλτρα';
		$strings['ViewDay'] = 'View Day';
		$strings['Group'] = 'Ομάδα';
		$strings['ManageConfiguration'] = 'Application Configuration';
		$strings['LookAndFeel'] = 'Look and Feel';
            //ranking
            $strings['RankingSystem'] = 'Σύστημα Κατάταξης';
            $strings['Ranking'] = 'Κατάταξη';
            $strings['Calls'] = 'Αγώνες κατάταξης';
            $strings['Tours'] = 'Τουρνουά';
            $strings['RankingCustomization'] = 'Παραμετροποίηση βαθμολογίας';
            $strings['RankingAdministration'] = 'Διαχείριση βαθμολογίας';
            $strings['RankingVariables'] = 'Αρχικοποίηση';
		// End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'Κ';
        $strings['DayMondaySingle'] = 'Δ';
        $strings['DayTuesdaySingle'] = 'Τ';
        $strings['DayWednesdaySingle'] = 'Τ';
        $strings['DayThursdaySingle'] = 'Π';
        $strings['DayFridaySingle'] = 'Π';
        $strings['DaySaturdaySingle'] = 'Σ';

        $strings['DaySundayAbbr'] = 'Κυρ';
        $strings['DayMondayAbbr'] = 'Δευ';
        $strings['DayTuesdayAbbr'] = 'Τρι';
        $strings['DayWednesdayAbbr'] = 'Τετ';
        $strings['DayThursdayAbbr'] = 'Πεμ';
        $strings['DayFridayAbbr'] = 'Παρ';
        $strings['DaySaturdayAbbr'] = 'Σαβ';
		// End Day representations

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Η κράτηση σας εγκρίθηκε';
        $strings['ReservationCreatedSubject'] = 'Η κράτηση δημιουργήθηκε επιτυχώς';
        $strings['ReservationUpdatedSubject'] = 'Η κράτηση ενημερώθηκε επιτυχώς';
        $strings['ReservationDeletedSubject'] = 'Η κράτησή σας ακυρώθηκε';
        $strings['ReservationCreatedAdminSubject'] = 'Ενημέρωση: Η κράτηση δημιουργήθηκε';
        $strings['ReservationUpdatedAdminSubject'] = 'Ενημέρωση: Η κράτηση ενημερώθηκε';
        $strings['ReservationDeleteAdminSubject'] = 'Ενημέρωση: Η κράτηση ακυρώθηκε';
        $strings['ParticipantAddedSubject'] = 'Κράτηση Συμμετοχή Ενημέρωση';
        $strings['ParticipantDeletedSubject'] = 'Η κράτηση ακυρώθηκε';
        $strings['InviteeAddedSubject'] = 'Πρόσκληση κράτησης';
        $strings['ResetPassword'] = 'Αίτηση επαναφοράς συνθηματικού';
        $strings['ActivateYourAccount'] = 'Παρακαλώ ενεργοποιήστε τον λογαριασμό σας';
		$strings['ReportSubject'] = 'Η αναζήτηση που ζητήσατε (%s)';
		$strings['ReservationStartingSoonSubject'] = 'Η κράτηση σας για το %s ξεκινάει σε λίγο';
		$strings['ReservationEndingSoonSubject'] = 'Η κράτηση σας για το %s τελειώνει σε λίγο';
		$strings['ReservationFirstParticipantCancellation'] = 'Ακύρωση από 1ο συμμετέχοντα';
        $strings['CancelledTraining'] = 'Η προπόνηση ακυρώθηκε';
        	//ranking
			$strings['YouHaveNewCall']= 'Έχετε νέα πρόσκληση για αγώνα';
			$strings['CallAccepted']= 'Επιβεβαίωση διεξαγωγής αγώνα';
			$strings['CallDeclined']= 'Ακύρωση διεξαγωγής αγώνα';
			$strings['CallReminder']= 'Εκκρεμεί απάντηση σας σε πρόσκληση';
			$strings['InsertCallDate']= 'Εκκρεμεί εισαγωγή ημερομηνίας σε πρόσκληση';
			$strings['InsertCallScore']= 'Εκκρεμεί εισαγωγή αποτελέσματος σε πρόσκληση';
			$strings['InsertCallDateInform']= 'Ενημέρωση ημερομηνίας αγώνα';
			$strings['DeleteAceGameReservationInform']= 'Ακύρωση διεξαγωγής αγώνα';
			$strings['ImageUpload']= 'Προσθήκη φωτογραφίας';
        // End Email Subjects

        $this->Strings = $strings;

        return $this->Strings;
    }

    protected function _LoadDays()
    {
        $days = array();

        /***
        DAY NAMES
        All of these arrays MUST start with Sunday as the first element
        and go through the seven day week, ending on Saturday
         ***/
        // The full day name
        $days['full'] = array('Κυριακή', 'Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο');
        // The three letter abbreviation
        $days['abbr'] = array('Κυρ', 'Δευ', 'Τρι', 'Τετ', 'Πεμ', 'Παρ', 'Σαβ');
        // The two letter abbreviation
        $days['two'] = array('Κυ', 'Δε', 'Τρ', 'Τε', 'Πε', 'Πα', 'Σα');
        // The one letter abbreviation
        $days['letter'] = array('Κ', 'Δ', 'Τ', 'Τ', 'Π', 'Π', 'Σ');

        $this->Days = $days;

        return $this->Days;
    }

    protected function _LoadMonths()
    {
        $months = array();

        /***
        MONTH NAMES
        All of these arrays MUST start with January as the first element
        and go through the twelve months of the year, ending on December
         ***/
        // The full month name
        $months['full'] = array('Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβριος', 'Οκτώβριος', 'Νοέμβριος', 'Δεκέμβριος');
        // The three letter month name
        $months['abbr'] = array('Ιαν', 'Φεβ', 'Μαρ', 'Απρ', 'Μαι', 'Ιον', 'Ιολ', 'Αυγ', 'Σεπ', 'Οκτ', 'Νοε', 'Δεκ');

        $this->Months = $months;

        return $this->Months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('Α', 'Β', 'Γ', 'Δ', 'Ε', 'Ζ', 'Η', 'Θ', 'Ι', 'Κ', 'Λ', 'Μ', 'Ν', 'Ξ', 'Ο', 'Π', 'Ρ', 'Σ', 'Τ', 'Υ', 'Φ', 'Χ', 'Ψ', 'Ω');

        return $this->Letters;
    }

    protected function _GetHtmlLangCode()
    {
        return 'gr';
    }
}

?>