import {Component} from "@angular/core";
import {Card} from "../classes/card";


@Component({
	templateUrl: "./templates/card.html",
	selector: "card"
})

//declare $ for jquery
declare let $: any;

export class CardComponent implements OnInit {
	cardForm: FormGroup;
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private weddingService: WeddingService) {
		console.log("Card Constructed")
	}

	ngOnInit(): void {
		this.cardForm = this.formBuilder.group({
			cardId: ["", [Validators.maxLength(128), Validators.required]],
			cardProfileId: ["", [Validators.maxLength(128), Validators.required]],
			cardWeddingId: ["", [Validators.maxLength(128), Validators.required]],
			cardChest: ["", [Validators.maxLength(4), Validators.required]],
			cardCoat: ["", [Validators.maxLength(4), Validators.required]],
			cardComplete: ["", [Validators.maxLength(4), Validators.required]],
			cardHeight: ["", [Validators.maxLength(4), Validators.required]],
			cardNeck: ["", [Validators.maxLength(4), Validators.required]],
			cardOutseam: ["", [Validators.maxLength(4), Validators.required]],
			cardPant: ["", [Validators.maxLength(4), Validators.required]],
			cardReviewed: ["", [Validators.maxLength(4), Validators.required]],
			cardShirt: ["", [Validators.maxLength(4), Validators.required]],
			cardShoeSize: ["", [Validators.maxLength(4), Validators.required]],
			cardSleeve: ["", [Validators.maxLength(4), Validators.required]],
			cardUnderarm: ["", [Validators.maxLength(4), Validators.required]],
			cardWeight: ["", [Validators.maxLength(4), Validators.required]],
		});
	}


	createCard(): void {

		let createCard = new Card (null, null, null, this.cardForm.value.cardChest, this.cardForm.value.cardCoat, this.cardForm.value.cardComplete, this.cardForm.value.cardHeight,this.cardForm.value.cardNeck, this.cardForm.value.cardOutseam, this.cardForm.value.cardPant, this.cardForm.value.cardReviewed, this.cardForm.value.cardShirt, this.cardForm.value.cardShoeSize, this.cardForm.value.cardSleeve, this.cardForm.value.cardUnderarm, this.cardForm.value.cardWeight);

		this.cardService.submitCard(submitCard)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {$("#card").modal('hide');}, 500);
					this.router.navigate(["card/:id"]);
				}
			});
	}
}