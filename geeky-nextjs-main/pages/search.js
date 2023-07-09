import Base from "@layouts/Baseof";
import apis from "@config/apis.json";
import { slugify } from "@lib/utils/textConverter";
import Post from "@partials/Post";
import axios from "axios";
import { useSearchContext } from "context/state";
import { useRouter } from "next/router";

const SearchPage = ({ searchPosts = [], searchKeyWord }) => {
  // const router = useRouter();
  // const { query } = router;
  // const keyword = slugify(query.key);
  console.log("searchKeyWord", searchKeyWord);
  console.log("searchPosts", searchPosts);

  // const { posts } = useSearchContext();

  // const searchPosts = posts.filter((product) => {
  //   if (product.frontmatter.draft) {
  //     return !product.frontmatter.draft;
  //   }
  //   if (slugify(product.frontmatter.title).includes(keyword)) {
  //     return product;
  //   } else if (
  //     product.frontmatter.categories.find((category) =>
  //       slugify(category).includes(keyword)
  //     )
  //   ) {
  //     return product;
  //   } else if (slugify(product.content).includes(keyword)) {
  //     return product;
  //   }
  // });

  return (
    <Base title={`Search results for ${searchKeyWord}`}>
      <div className="section">
        <div className="container">
          <h1 className="h2 mb-8 text-center">
            Search results for{" "}
            <span className="text-primary">{searchKeyWord}</span>
            Total Result :{" "}
            <span className="text-primary">{searchPosts.length}</span>
          </h1>
          {searchPosts.length > 0 ? (
            <div className="row">
              {searchPosts.map((post, i) => (
                <div key={post.id} className="col-12 mb-8 sm:col-6">
                  <Post post={post} />
                </div>
              ))}
            </div>
          ) : (
            <div className="py-24 text-center text-h3 shadow">
              No Search Found
            </div>
          )}
        </div>
      </div>
    </Base>
  );
};

export default SearchPage;

// for homepage sever side data
export const getServerSideProps = async ({ query }) => {
  // recent post data
  const searchKeyWord = query.key;
  // hit to the search api
  try {
    const response = await axios(
      `${apis.search}?search=${searchKeyWord}&orderBy=published_at`
    );
    var searchPosts = await response?.data?.data;
  } catch (error) {
    console.error(error);
  }

  return {
    props: {
      searchPosts,
      searchKeyWord,
    },
  };
};
