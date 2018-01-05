import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";
import {Wedding} from "../classes/wedding";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class WeddingService {

	constructor(protected http: HttpClient) {}

	private createWeddingUrl = "api/wedding/";



	getAllWeddings() : Observable<Wedding[]> {
		return(this.http.get<Wedding[]>(this.createWeddingUrl));
	}

	createWedding(wedding: Wedding) : Observable<Status> {
		return(this.http.post<Status>(this.createWeddingUrl, wedding));
	}

	editWedding(wedding: Wedding) : Observable<Status> {
		return(this.http.put<Status>(this.createWeddingUrl + wedding.weddingId, wedding));
	}

	getWeddingDetails(weddingId: string) : Observable<Wedding> {
		return(this.http.get<Wedding>(this.createWeddingUrl + weddingId));
	}
}