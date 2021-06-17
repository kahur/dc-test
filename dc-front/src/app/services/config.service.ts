import {Injectable} from "@angular/core";
import {environment} from "../../environments/environment";

@Injectable({
  providedIn: "root"
})
export class ConfigService {
  public getConfig(name: string) {
    let config = <any>environment;

    return config[name] ?? null;
  }
}
