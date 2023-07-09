import config from "@config/config.json";
import PostSingle from "@layouts/PostSingle";
import apis from "@config/apis.json";
import axios from "axios";

// post single layout
const Article = ({ post, posts }) => {
  // const { frontmatter, content } = post;
  console.log("post data ", post);
  return (
    <PostSingle post={post} posts={posts} />
    // <h1> hello </h1>
  );
};

export default Article;

// This function fetches the data for a single post based on the ID or slug
export async function getServerSideProps({ params }) {
  const postId = params.id;

  // Fetch the post data using the ID or slug
  try {
    const response = await axios(`${apis.posts}/${postId}`);
    var post = await response.data;
  } catch (error) {
    console.error(error);
  }

  if (!post) {
    // If the post doesn't exist, return a 404 page
    return {
      notFound: true,
    };
  }
  // additional props
  try {
    const response = await axios(`${apis.posts}`);
    var posts = await response.data;
  } catch (error) {
    console.error(error);
  }

  return {
    props: {
      post: post.data,
      posts: posts.data,
    },
  };
}
