import config from "@config/config.json";
import Base from "@layouts/Baseof";
import Pagination from "@layouts/components/Pagination";
// import { getListPage, getSinglePage } from "@lib/contentParser";
import { markdownify } from "@lib/utils/textConverter";
import Post from "@partials/Post";
import axios from "axios";
import apis from "@config/apis.json";
import psotsPage from "@config/pages/posts.json";

const { blog_folder, summary_length, pagination } = config.settings;

// blog pagination
const BlogPage = ({ postsData, postsMeta }) => {
  const totalPages = postsMeta?.last_page;
  const currentPage = postsMeta?.current_page;

  return (
    <Base title={psotsPage.title}>
      <section className="section">
        <div className="container">
          {markdownify(psotsPage.title, "h1", "h2 mb-8 text-center")}
          <div className="row mb-16">
            {postsData.map((post, i) => (
              <div className="mt-16 lg:col-6" key={post.slug}>
                <Post post={post} />
              </div>
            ))}
          </div>
          <Pagination totalPages={totalPages} currentPage={currentPage} />
        </div>
      </section>
    </Base>
  );
};

export default BlogPage;

// get blog pagination content
export const getServerSideProps = async ({ params }) => {
  const paginationPageNo = params?.page ? Number(params?.page) : 1;
  // recent posts
  try {
    const response = await axios(
      `${apis.posts}?orderBy=published_at&page=${paginationPageNo}`
    );
    var posts = await response.data;
    console.log(posts);
  } catch (error) {
    console.error(error);
  }

  return {
    props: {
      postsData: posts.data,
      postsMeta: posts.meta,
    },
  };
};
