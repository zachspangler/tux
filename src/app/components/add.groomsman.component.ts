import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignUpService} from "../services/sign.up.service";
import {WeddingService} from "../services/wedding.service";
import {SignUp} from "../classes/sign.up";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

//declare $ for jquery
declare let $: any;

@Component({
	selector: "add-groomsman",
	templateUrl: "./templates/add-groomsman.html"
})

export class AddGroomsmanComponent implements OnInit {
	addGroomsmanForm: FormGroup;
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private signUpService: SignUpService) {
		console.log("Groomsman Added")
	}

	ngOnInit(): void {
		this.addGroomsmanForm = this.formBuilder.group({
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profileFirstName: ["", [Validators.maxLength(32), Validators.required]],
			profileLastName: ["", [Validators.maxLength(32), Validators.required]],
			profilePhone: ["", [Validators.maxLength(32)]],
			profilePassword: ["", [Validators.maxLength(48), Validators.required]],
			profilePasswordConfirm: ["", [Validators.maxLength(48), Validators.required]],
		});
	}

	addGroomsman(): void {

		let signUp = new SignUp(this.addGroomsmanForm.value.profileEmail, this.addGroomsmanForm.value.profileFirstName, this.addGroomsmanForm.value.profileLastName, this.addGroomsmanForm.value.profilePhone, this.addGroomsmanForm.value.profilePassword, this.addGroomsmanForm.value.profilePasswordConfirm);

		this.signUpService.createProfile(signUp)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {$("#addGroomsman").modal('hide');}, 500);
				}
			});

		this.reloadWeddingDetails();
	}

	reloadWeddingDetails() : void {
		this.weddingService.getWeddingDetails()
			.subscribe(wedding => this.wedding = wedding);
	}
}