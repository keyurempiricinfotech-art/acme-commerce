import { ProductRepository } from "../catalog/ProductRepository";
import { CategoryRepository } from "../catalog/CategoryRepository";

export class CatalogService {
  constructor(
    private readonly productRepository: ProductRepository,
    private readonly categoryRepository: CategoryRepository
  ) {}

  async search(term: string) {
    return this.productRepository.searchProducts(term);
  }

  async categories() {
    return this.categoryRepository.getTree();
  }
}
