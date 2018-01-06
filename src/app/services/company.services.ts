import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Company} from "../classes/company";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class CompanyService {

	constructor(protected http: HttpClient) {

	}

	//define the API endpoint
	private companyUrl: string = "api/company/";


}