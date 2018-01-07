import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {WeddingParty} from "../classes/weddingParty";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";
import {Wedding} from "../classes/wedding";
import {Card} from "../classes/card";

@Injectable ()
export class WeddingPartyService {

	constructor(protected http: HttpClient) {

	}

	//define the API endpoint
	private weddingPartyUrl: string = "api/wedding-party/";


	//all getBys
	getWeddingPartyByWeddingPartyId(id: string) : Observable<WeddingParty> {
		return(this.http.get<WeddingParty>(this.weddingPartyUrl + id));
	}

	getWeddingPartyByWeddingPartyWeddingId(weddingPartyWeddingId: string) : Observable<WeddingParty[]> {
		return(this.http.get<WeddingParty[]>(this.weddingPartyUrl + "?weddingPartyWeddingId" + weddingPartyWeddingId));
	}

	getWeddingPartyByWeddingPartyProfileId(weddingPartyProfileId: string) : Observable<WeddingParty[]> {
		return(this.http.get<WeddingParty[]>(this.weddingPartyUrl + "?weddingPartyProfileId" + weddingPartyProfileId));
	}

	getWeddingDetails() : Observable<Wedding[]> {
		return(this.http.get<Wedding[]>(this.weddingPartyUrl));
	}
}