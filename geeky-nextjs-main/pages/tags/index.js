import config from "@config/config.json";
import Base from "@layouts/Baseof";
import { humanize, markdownify } from "@lib/utils/textConverter";
import Link from "next/link";
const { blog_folder } = config.settings;
import apis from "@config/apis.json";
import { FaFolder } from "react-icons/fa";
import axios from "axios";
import ImageFallback from "@layouts/components/ImageFallback";

const Categories = ({ tags }) => {
  return (
    <Base title={"tags"}>
      <section className="section pt-0">
        {markdownify(
          "Categories",
          "h1",
          "h2 mb-16 bg-theme-light dark:bg-darkmode-theme-dark py-12 text-center lg:text-[55px]"
        )}
        <div className="container pt-12 text-center">
          <ul className="row">
            {tags.map((tag, i) => (
              <li key={tag.id} className="mt-4 block lg:col-4 xl:col-3">
                <Link
                  // href={`/tags/${tag.slug}`}
                  href={{
                    pathname: "/tags/[tag]",
                    query: { tag: tag.id },
                  }}
                  as={`/tags/${tag.id}/${encodeURIComponent(tag.slug)}`}
                  className="flex w-full flex-col items-center justify-center rounded-lg bg-theme-light px-4 py-4 font-bold text-dark transition hover:bg-primary hover:text-white  dark:bg-darkmode-theme-dark dark:text-darkmode-light dark:hover:bg-primary dark:hover:text-white"
                >
                  <div className="card">
                    <ImageFallback
                      className="rounded"
                      src={tag.image}
                      alt={tag.title}
                      width={405}
                      height={208}
                    />
                  </div>
                  <FaFolder className="mr-1.5 flex flex-row" />
                  {humanize(tag.name)} ({tag.post.length} )
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
  // tag
  try {
    // ?orderBy=views
    const response = await axios(`${apis.tags}`);
    var tags = await response.data;
  } catch (error) {
    console.error(error);
  }
  return {
    props: {
      tags: tags.data,
    },
  };
};
