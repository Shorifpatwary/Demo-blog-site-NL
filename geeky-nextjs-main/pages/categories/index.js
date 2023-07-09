import config from "@config/config.json";
import Base from "@layouts/Baseof";
import { humanize, markdownify } from "@lib/utils/textConverter";
import Link from "next/link";
const { blog_folder } = config.settings;
import apis from "@config/apis.json";
import { FaFolder } from "react-icons/fa";
import axios from "axios";

const Categories = ({ categories }) => {
  return (
    <Base title={"categories"}>
      <section className="section pt-0">
        {markdownify(
          "Categories",
          "h1",
          "h2 mb-16 bg-theme-light dark:bg-darkmode-theme-dark py-12 text-center lg:text-[55px]"
        )}
        <div className="container pt-12 text-center">
          <ul className="row">
            {categories.map((category, i) => (
              <li key={category.id} className="mt-4 block lg:col-4 xl:col-3">
                <Link
                  // href={`/categories/${category.slug}`}
                  href={{
                    pathname: "/categories/[category]",
                    query: { category: category.id },
                  }}
                  as={`/categories/${category.id}/${encodeURIComponent(
                    category.slug
                  )}`}
                  className="flex w-full items-center justify-center rounded-lg bg-theme-light px-4 py-4 font-bold text-dark transition hover:bg-primary hover:text-white  dark:bg-darkmode-theme-dark dark:text-darkmode-light dark:hover:bg-primary dark:hover:text-white"
                >
                  <FaFolder className="mr-1.5" />
                  {humanize(category.name)} ({category.post.length} )
                </Link>
              </li>
            ))}
          </ul>
        </div>
      </section>
    </Base>
  );
};

export default Categories;

export const getServerSideProps = async () => {
  // category
  try {
    // ?orderBy=views
    const response = await axios(`${apis.categories}`);
    var categories = await response.data;
  } catch (error) {
    console.error(error);
  }
  return {
    props: {
      categories: categories.data,
    },
  };
};
