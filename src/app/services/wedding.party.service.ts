import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {WeddingParty} from "../classes/weddingParty";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class WeddingPartyService {

	constructor(protected http: HttpClient) {

	}

	//define the API endpoint
	private weddingDetailsUrl: string = "api/wedding-party/";


}