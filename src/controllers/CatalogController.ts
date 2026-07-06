import { CatalogService } from "../services/CatalogService";

export class CatalogController {
  constructor(private readonly catalogService: CatalogService) {}

  search = async (req: any, res: any) => {
    const result = await this.catalogService.search(String(req.query.q ?? ""));
    res.json(result);
  };

  categories = async (_req: any, res: any) => {
    const result = await this.catalogService.categories();
    res.json(result);
  };
}
