import {Component, OnInit} from "@angular/core";
import {Status} from "../classes/status";
import {JwtHelperService} from "@auth0/angular-jwt";
import {ActivatedRoute} from "@angular/router";
import {Router} from "@angular/router";
import {WeddingService} from "../services/wedding.service";
import {Wedding} from "../classes/wedding";


@Component({
	templateUrl: "./templates/home.html"
})

export class HomeComponent implements OnInit {
	weddings: Wedding[] = [];
	status: Status = null;

	constructor(private weddingService: WeddingService, private router: Router) {}

	ngOnInit() : void {
		this.reloadWedding();
	}

	reloadWedding() : void {
		this.weddingService.getAllWeddings()
			.subscribe(weddings => this.weddings = weddings);
	}

	switchWedding(wedding : Wedding) : void {
		this.router.navigate(["/wedding/", this.weddings.weddingId]);
	}
}