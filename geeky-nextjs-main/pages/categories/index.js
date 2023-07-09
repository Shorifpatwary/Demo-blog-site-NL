import config from "@config/config.json";
import Base from "@layouts/Baseof";
import { humanize, markdownify } from "@lib/utils/textConverter";
import Link from "next/link";
const { blog_folder } = config.settings;
import apis from "@config/apis.json";
import { FaFolder } from "react-icons/fa";
import axios from "axios";
import ImageFallback from "@layouts/components/ImageFallback";

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
                  className="flex w-full flex-col items-center justify-center rounded-lg bg-theme-light px-4 py-4 font-bold text-dark transition hover:bg-primary hover:text-white  dark:bg-darkmode-theme-dark dark:text-darkmode-light dark:hover:bg-primary dark:hover:text-white"
                >
                  <div className="card">
                    <ImageFallback
                      className="rounded"
                      src={category.image}
                      alt={category.title}
                      width={405}
                      height={208}
                    />
                  </div>
                  <div className="mt-3 flex flex-row content-center">
                    <FaFolder className="mr-2 mt-1" />
                    {humanize(category.name)} ({category.post.length} )
                  </div>
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
