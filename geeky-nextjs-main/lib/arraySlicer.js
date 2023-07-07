/**
 *
 * @param    Array  to slice  categories
 * @param Num  numberOfItem to slice
 * @returns categories array sliced items . if categories is > numberOfItem slice total numberOfItem else return categories without slice
 */
function ArraySlicer(categories, numberOfItem = 8) {
  const categoriesLength = categories.length;
  if (categoriesLength > numberOfItem) {
    var categories = categories.slice(0, numberOfItem);
  } else {
    var categories = categories;
  }
  return categories;
}
export default ArraySlicer;
