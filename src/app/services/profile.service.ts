import {Injectable} from "@angular/core";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Observable} from "rxjs/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ProfileService {

	constructor(protected http: HttpClient) {

	}

	//define the API endpoint
	private profileUrl: string = "api/profile/";

	getProfile(id: string): Observable<Profile> {
		return (this.http.get<Profile>(this.profileUrl + id));
	}

	getProfileByProfileEmail(profileEmail: string): Observable<Profile[]> {
		return (this.http.get<Profile[]>(this.profileUrl + "?profileEmail=" + profileEmail));
	}

	getProfileByProfileName(profileName: string): Observable<Profile[]> {
		return (this.http.get<Profile[]>(this.profileUrl + "?profileName=" + profileName));
	}

	getProfileByProfilePhone(profilePhone: string): Observable<Profile> {
		return (this.http.get<Profile>(this.profileUrl + "?profilePhone=" + profilePhone));
	}

	getAllProfiles() : Observable<Profile[]> {
		return (this.http.get<Profile[]>(this.profileUrl));
	}
}