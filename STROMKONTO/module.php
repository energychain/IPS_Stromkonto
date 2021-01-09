<?php
	class STROMKONTO extends IPSModule {

		/**
		 * Coding note: in general it is not allowed to create variable outside of create method.
		 * However as subaccounts may change at any time, it is required to check which are available and create new variables ondemand
		 */
		public function update() {
			$objectid =  $this->InstanceID;
			$account = $this->ReadPropertyString("account");
	    $skodata = json_decode(file_get_contents("https://api.corrently.io/v2.0/stromkonto/balances?account=".$account));

	    // Check if we have all required Profiles

	    if(!IPS_VariableProfileExists("WattHours")) {
	        IPS_CreateVariableProfile ("WattHours", 1);
	        IPS_SetVariableProfileDigits ("WattHours", 0);
	        IPS_SetVariableProfileText ("WattHours", "", "Wh");
	    }

	    if(!IPS_VariableProfileExists("Gramm")) {
	        IPS_CreateVariableProfile ("Gramm", 1);
	        IPS_SetVariableProfileDigits ("Gramm", 0);
	        IPS_SetVariableProfileText ("Gramm", "", "g");
	    }

	    if(!IPS_VariableProfileExists("WattHoursPerAnno")) {
	        IPS_CreateVariableProfile ("WattHoursPerAnno", 1);
	        IPS_SetVariableProfileDigits ("WattHoursPerAnno", 0);
	        IPS_SetVariableProfileText ("WattHoursPerAnno", "", "wha");
	    }

	    if(!IPS_VariableProfileExists("GreenPowerIndex")) {
	        IPS_CreateVariableProfile ("GreenPowerIndex", 1);
	        IPS_SetVariableProfileDigits ("GreenPowerIndex", 0);
	        IPS_SetVariableProfileText ("GreenPowerIndex", "", "gsi");
	    }
	    foreach($skodata as $subaccount) {
	        $variation = $subaccount->variation;

	        $id_variation = @IPS_GetObjectIDByName($variation, $objectid);
	        $profile = "";
	        if($variation == 'gsb') $profile = "WattHours";
	        if($variation == 'eigenstrom') $profile = "WattHours";
	        if($variation == 'co2') $profile = "Gramm";
	        if($variation == 'erzeugung') $profile = "WattHoursPerAnno";
	        if($variation == 'gsi') $profile = "GreenPowerIndex";

	        if(!$id_variation) {
	            $id_variation = IPS_CreateCategory();
	            IPS_SetName($id_variation, $variation);
	            IPS_SetParent($id_variation, $objectid);
	        }

	        if(isset($subaccount->saldo)) {
	            $id_saldo = @IPS_GetObjectIDByName("saldo", $id_variation);
	            if(!$id_saldo) {
	                $id_saldo = IPS_CreateVariable(1);
	                IPS_SetName($id_saldo, "saldo");
	                IPS_SetParent($id_saldo, $id_variation);
	                IPS_SetVariableCustomProfile ($id_saldo, $profile);
	            }
	            SetValue($id_saldo,$subaccount->saldo);
	        }

	        if(isset($subaccount->soll)) {
	            $id_soll = @IPS_GetObjectIDByName("soll", $id_variation);
	            if(!$id_soll) {
	                $id_soll = IPS_CreateVariable(1);
	                IPS_SetName($id_soll, "soll");
	                IPS_SetParent($id_soll, $id_variation);
	                IPS_SetVariableCustomProfile ($id_soll, $profile);
	            }
	            SetValue($id_soll,$subaccount->soll);
	        }

	        if(isset($subaccount->haben)) {
	            $id_haben = @IPS_GetObjectIDByName("haben", $id_variation);
	            if(!$id_haben) {
	                $id_haben = IPS_CreateVariable(1);
	                IPS_SetName($id_haben, "haben");
	                IPS_SetParent($id_haben, $id_variation);
	                IPS_SetVariableCustomProfile ($id_haben, $profile);
	            }
	            SetValue($id_haben,$subaccount->haben);
	        }
	    }
		}

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->RegisterPropertyString("account", "0x7866f187f30cd52Bdbd5c4184fD3ee6168Ae0dB4");

			// this is ugly .. not a nicer way to trigger Self counter...
			$this->RegisterTimer("UpdateTimer", 900 * 1000, 'SKO_update($_IPS[\'TARGET\']);');
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
		}

	}
