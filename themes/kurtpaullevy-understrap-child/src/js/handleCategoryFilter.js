import { filterContentByCategoryAjax } from "./ajax/filterContentByCategoryAjax";

export function handleCategoryFilter($, categoryText) {
  filterContentByCategoryAjax($, { category: categoryText });
}