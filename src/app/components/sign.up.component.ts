/*
 this component is for signing up to use the site.
 */

import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignUpService} from "../services/sign.up.service";
import {SignUp} from "../classes/sign.up";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

//declare $ for jquery
declare let $: any;

@Component({
	selector: "sign-up",
	templateUrl: "./templates/sign-up.html"
})

export class SignUpComponent implements OnInit {

	signUpForm: FormGroup;

	// signUp: SignUp = new SignUp(null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private signUpService: SignUpService) {
		console.log("Profile Constructed")
	}

	ngOnInit(): void {
		this.signUpForm = this.formBuilder.group({
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profileFirstName: ["", [Validators.maxLength(32), Validators.required]],
			profileLastName: ["", [Validators.maxLength(32), Validators.required]],
			profilePhone: ["", [Validators.maxLength(32)]],
			profilePassword: ["", [Validators.maxLength(48), Validators.required]],
			profilePasswordConfirm: ["", [Validators.maxLength(48), Validators.required]]
		});
	}


	createSignUp(): void {

		let signUp = new SignUp(this.signUpForm.value.profileEmail, this.signUpForm.value.profileFirstName, this.signUpForm.value.profileLastName, this.signUpForm.value.profilePhone, this.signUpForm.value.profilePassword, this.signUpForm.value.profilePasswordConfirm);

		this.signUpService.createProfile(signUp)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {$("#join").modal('hide');}, 500);
					this.router.navigate([""]);
				}
			});
	}
}