import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";
import {Card} from "../classes/card";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class CardService {

	constructor(protected http: HttpClient) {
	}

	private cardUrl = "api/card/";


	createCard(card: Card) : Observable<Status> {
		return(this.http.post<Status>(this.cardUrl, card))
	}

}