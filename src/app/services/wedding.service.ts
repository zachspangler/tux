import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";
import {Wedding} from "../classes/wedding";
import {HttpClient} from "@angular/common/http";
import {Card} from "../classes/card";

@Injectable()
export class WeddingService {

	constructor(protected http: HttpClient) {}

	private weddingUrl = "api/wedding/";


	createWedding(wedding: Wedding) : Observable<Status> {
		return(this.http.post<Status>(this.weddingUrl, wedding));
	}

	editWedding(wedding: Wedding) : Observable<Status> {
		return(this.http.put<Status>(this.weddingUrl + wedding.weddingId, wedding));
	}


	//all getBys
	getWeddingByWeddingId(id: string) : Observable<Wedding> {
		return (this.http.get<Wedding>(this.weddingUrl + id));
	}

	getWeddingByCompanyId(weddingCompanyId: string) : Observable<Wedding[]> {
		return (this.http.get<Wedding[]>(this.weddingUrl + "?weddingCompanyId" + weddingCompanyId));
	}

	getWeddingByWeddingDate(weddingDate: string) : Observable<Wedding[]> {
			return(this.http.get<Wedding[]>(this.weddingUrl + "?weddingDate" + weddingDate));
	}

	getWeddingByWeddingName(weddingName: string) : Observable<Wedding[]> {
		return(this.http.get<Wedding[]>(this.weddingUrl + "?weddingName" + weddingName));
	}

	getWeddingByWeddingReturnByDate(weddingReturnByDate: string) : Observable<Wedding[]> {
		return(this.http.get<Wedding[]>(this.weddingUrl + "?weddingReturnByDate" + weddingReturnByDate));
	}

	getAllWeddings() : Observable<Wedding[]> {
		return(this.http.get<Wedding[]>(this.weddingUrl));
	}
}