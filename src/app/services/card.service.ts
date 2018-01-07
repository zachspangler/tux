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

	getCardByCardId(id: string) : Observable<Card> {
		return(this.http.get<Card>(this.cardUrl + id));
	}

	getCardByProfileId(cardProfileId: string) : Observable<Card[]> {
		return(this.http.get<Card[]>(this.cardUrl + "?cardProfileId" + cardProfileId));
	}

	getCardByWeddingId(cardWeddingId: string) : Observable<Card[]> {
		return(this.http.get<Card[]>(this.cardUrl + "?cardWeddingId" + cardWeddingId));
	}

	getAllCards() : Observable<Card[]> {
		return(this.http.get<Card[]>(this.cardUrl));
	}

}