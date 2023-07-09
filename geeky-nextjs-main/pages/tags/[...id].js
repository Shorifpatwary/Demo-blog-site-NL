import config from "@config/config.json";
import apis from "@config/apis.json";

import Base from "@layouts/Baseof";
import Sidebar from "@layouts/partials/Sidebar";

import Post from "@partials/Post";
import axios from "axios";
const { blog_folder } = config.settings;

// tag page
const Category = ({ tag }) => {
  return (
    <Base title={tag.name}>
      <div className="section mt-16">
        <div className="container">
          <h1 className="h2 mb-12">
            Showing posts from
            <span className="section-title ml-1 inline-block capitalize">
              {/* {tag.replace("-", " ")} */}
              {tag.name}
            </span>
          </h1>
          <div className="row">
            <div className="lg:col-8">
              <div className="row rounded border border-border p-4 px-3 dark:border-darkmode-border lg:p-6">
                {tag.post.map((post, i) => (
                  <div key={post.id} className="col-12 mb-8 sm:col-6">
                    <Post post={post} />
                  </div>
                ))}
              </div>
            </div>
            <Sidebar />
          </div>
        </div>
      </div>
    </Base>
  );
};

export default Category;

export async function getServerSideProps({ params }) {
  const tagId = params.id;
  // Fetch the post data using the ID or slug
  try {
    const response = await axios(`${apis.tags}/${tagId}`);
    var tag = await response.data;
  } catch (error) {
    console.error(error);
  }

  if (!tag) {
    // If the post doesn't exist, return a 404 page
    return {
      notFound: true,
    };
  }

  return {
    props: {
      tag: tag.data,
    },
  };
}
