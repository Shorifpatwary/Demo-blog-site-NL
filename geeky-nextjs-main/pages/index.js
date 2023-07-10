import config from "@config/config.json";
import apis from "@config/apis.json";
import homePageData from "@config/pages/home.json";
import Base from "@layouts/Baseof";
import ImageFallback from "@layouts/components/ImageFallback";
import Pagination from "@layouts/components/Pagination";
import Post from "@layouts/partials/Post";
import Sidebar from "@layouts/partials/Sidebar";
// import { getListPage, getSinglePage } from "@lib/contentParser";
// import { getTaxonomy } from "@lib/taxonomyParser";
// import dateFormat from "@lib/utils/dateFormat";
// import { sortByDate } from "@lib/utils/sortFunctions";
import ArraySlicer from "@lib/arraySlicer";
import cutStringToWords from "@lib/cutStringToWords";
import { markdownify } from "@lib/utils/textConverter";
import Link from "next/link";
import { FaRegCalendar } from "react-icons/fa";
import axios from "axios";

const { blog_folder, pagination } = config.settings;
const { banner, featured_posts, recent_posts, promotion } = homePageData;

const Home = ({ recentPosts, featuredPosts, categories }) => {
  const recentPostsData = recentPosts.data;
  const recentPostsMeta = recentPosts.meta;

  const featuredPostsData = featuredPosts.data;
  const featuredPostsMeta = featuredPosts.meta;

  // define state
  // const showPosts = pagination;

  return (
    <Base>
      {/* Banner */}
      <section className="section banner relative pb-0">
        <ImageFallback
          className="absolute bottom-0 left-0 z-[-1] w-full"
          src={"/images/banner-bg-shape.svg"}
          width={1905}
          height={295}
          alt="banner-shape"
          priority
        />

        <div className="container">
          <div className="row flex-wrap-reverse items-center justify-center lg:flex-row">
            <div
              className={
                banner?.image_enable
                  ? "mt-12 text-center lg:col-6 lg:mt-0 lg:text-left"
                  : "mt-12 text-center lg:col-12 lg:mt-0 lg:text-left"
              }
            >
              <div className="banner-title">
                {markdownify(banner?.title, "h1")}
                {markdownify(banner?.title_small, "span")}
              </div>
              {markdownify(banner?.content, "p", "mt-4")}
              {banner?.button.enable && (
                <Link
                  className="btn btn-primary mt-6"
                  href={banner?.button.link}
                  rel={banner?.button.rel}
                >
                  {banner?.button.label}
                </Link>
              )}
            </div>
            {banner?.image_enable && (
              <div className="col-9 lg:col-6">
                <ImageFallback
                  className="mx-auto object-contain"
                  src={banner?.image}
                  width={548}
                  height={443}
                  priority={true}
                  alt="Banner Image"
                />
              </div>
            )}
          </div>
        </div>
      </section>

      {/* Home main */}
      <section className="section">
        <div className="container">
          <div className="row items-start">
            <div className="mb-12 lg:col-8 lg:mb-0">
              {/* Featured posts */}
              {featured_posts?.enable && (
                <div className="section">
                  {markdownify(featured_posts?.title, "h2", "section-title")}
                  <div className="rounded border border-border p-6 dark:border-darkmode-border">
                    <div className="row">
                      <div className="md:col-6">
                        <Post post={featuredPostsData[0]} />
                      </div>
                      <div className="scrollbar-w-[10px] mt-8 max-h-[480px] scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-border md:col-6 dark:scrollbar-track-gray-800 dark:scrollbar-thumb-darkmode-theme-dark md:mt-0">
                        {featuredPostsData
                          .slice(1, featuredPostsData.length)
                          .map((post, i, arr) => (
                            <div
                              className={`mb-6 flex items-center pb-6 ${
                                i !== arr.length - 1 &&
                                "border-b border-border dark:border-darkmode-border"
                              }`}
                              key={post.id}
                            >
                              {post.image && (
                                <ImageFallback
                                  className="mr-3 h-[85px] rounded object-cover"
                                  src={post.image}
                                  alt={post.title}
                                  width={105}
                                  height={85}
                                />
                              )}
                              <div>
                                <h3 className="h5 mb-2">
                                  <Link
                                    // href={post.slug}
                                    href={{
                                      pathname: "/posts/[id]",
                                      query: { id: post.id },
                                    }}
                                    as={`/posts/${post.id}/${encodeURIComponent(
                                      post.title
                                    )}`}
                                    className="block hover:text-primary"
                                  >
                                    {/* {post.title.slice(0, 50)} */}
                                    {cutStringToWords(post.title, 6)}
                                  </Link>
                                </h3>
                                <p className="inline-flex items-center font-bold">
                                  <FaRegCalendar className="mr-1.5" />
                                  {post.published_at}
                                </p>
                              </div>
                            </div>
                          ))}
                      </div>
                    </div>
                  </div>
                </div>
              )}

              {/* Promotion */}
              {promotion.enable && (
                <Link href={promotion.link} className="section block pt-0">
                  <ImageFallback
                    className="h-full w-full"
                    height="115"
                    width="800"
                    src={promotion.image}
                    alt="promotion"
                  />
                </Link>
              )}

              {/* Recent Posts */}
              {recent_posts?.enable && (
                <div className="section pt-0">
                  {markdownify(recent_posts?.title, "h2", "section-title")}
                  <div className="rounded border border-border px-6 pt-6 dark:border-darkmode-border">
                    <div className="row">
                      {recentPostsData
                        .slice(0, recentPostsMeta.per_page)
                        .map((post) => (
                          <div className="mb-8 md:col-6" key={post.id}>
                            <Post post={post} />
                          </div>
                        ))}
                    </div>
                  </div>
                </div>
              )}

              {/* <Pagination
                totalPages={Math.ceil(posts.length / showPosts)}
                currentPage={1}
              /> */}
              {/* show more link */}
              <div className="align-items-center flex">
                <Link
                  href="/posts"
                  className="btn btn-outline-primary text-primary-400 mt-4 p-3 font-bold capitalize"
                >
                  Show more ...
                </Link>
              </div>
            </div>
            {/* sidebar */}
            <Sidebar className={"lg:mt-[9.5rem]"} />
          </div>
        </div>
      </section>
    </Base>
  );
};

export default Home;

// for homepage sever side data
export const getServerSideProps = async () => {
  // recent post data
  try {
    const response = await axios(`${apis.posts}?orderBy=published_at`);
    var recentPosts = await response.data;
  } catch (error) {
    console.error(error);
  }
  // recent post data
  try {
    const response = await axios(`${apis.posts}?orderBy=views`);
    var featuredPosts = await response.data;
  } catch (error) {
    console.error(error);
  }
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
      recentPosts,
      featuredPosts,
      categories: categories.data,
    },
  };
};
