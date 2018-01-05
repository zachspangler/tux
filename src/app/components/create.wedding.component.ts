import {Component, OnInit} from "@angular/core";
import {Status} from "../classes/status";
import {Router} from "@angular/router";
import {setTimeout} from "timers";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {WeddingService} from "../services/wedding.service";
import {Wedding} from "../classes/wedding";

//declare $ for jquery
declare let $: any;

@Component({
	selector: "create-wedding",
	templateUrl: "./templates/create-wedding.html"
})

export class CreateWeddingComponent implements OnInit {
	createWeddingForm: FormGroup;
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private weddingService: WeddingService) {
		console.log("Wedding Constructed")
	}

	ngOnInit(): void {
		this.createWeddingForm = this.formBuilder.group({
			weddingCompany: ["", [Validators.maxLength(128), Validators.required]],
			weddingDate: ["", [Validators.maxLength(32), Validators.required]],
			weddingName: ["", [Validators.maxLength(32), Validators.required]],
			weddingReturnByDate: ["", [Validators.maxLength(32)]],
		});
	}


	createWedding(): void {

		let createWedding = new Wedding (null, this.createWeddingForm.value.weddingCompany, this.createWeddingForm.value.weddingDate, this.createWeddingForm.value.weddingName, this.createWeddingForm.value.weddingReturnByDate);

		this.weddingService.createWedding(createWedding)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {$("#createWedding").modal('hide');}, 500);
					this.router.navigate(["wedding/:id"]);
				}
			});
	}
}