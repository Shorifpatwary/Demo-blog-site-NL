import config from "@config/config.json";
import Base from "@layouts/Baseof";
import InnerPagination from "@layouts/components/InnerPagination";
import { markdownify } from "@lib/utils/textConverter";
import { useTheme } from "next-themes";
import Image from "next/image";
import Link from "next/link";
import { FaRegCalendar, FaUserAlt } from "react-icons/fa";
import Post from "./partials/Post";
import Sidebar from "./partials/Sidebar";
import { DiscussionEmbed } from "disqus-react";
const { disqus } = config;
const { meta_author } = config.metadata;

const PostSingle = ({ post, posts, relatedPosts }) => {
  const description = post.description
    ? post.description
    : post.content.slice(0, 120);

  const { theme } = useTheme();
  const author = post.user.name ? post.user.name : meta_author;
  // Local copy so we don't modify global config.

  return (
    <Base title={post.title} description={description}>
      <section className="section single-blog mt-6">
        <div className="container">
          <div className="row">
            <div className="lg:col-8">
              <article>
                <div className="relative">
                  {post.image && (
                    <Image
                      src={post.image}
                      height="500"
                      width="1000"
                      alt={post.title}
                      className="rounded-lg"
                    />
                  )}
                  <ul className="absolute left-2 top-3 flex flex-wrap items-center">
                    {post.category.map((category, index) => (
                      <li
                        className="mx-2 inline-flex h-7 rounded-[35px] bg-primary px-3 text-white"
                        key={category.id}
                      >
                        <Link
                          className="capitalize"
                          href={`/categories/${category.slug}`}
                        >
                          {category.name}
                        </Link>
                      </li>
                    ))}
                  </ul>
                </div>
                {config.settings.InnerPaginationOptions.enableTop && (
                  <div className="mt-4">
                    {/* <InnerPagination posts={posts} date={post.published_at} /> */}
                  </div>
                )}
                {markdownify(post.title, "h1", "lg:text-[42px] mt-4")}
                <ul className="flex items-center space-x-4">
                  <li>
                    <Link
                      className="inline-flex items-center font-secondary text-xs leading-3"
                      href="/about"
                    >
                      <FaUserAlt className="mr-1.5" />
                      {post.user.name}
                    </Link>
                  </li>
                  <li className="inline-flex items-center font-secondary text-xs leading-3">
                    <FaRegCalendar className="mr-1.5" />
                    {/* {dateFormat(date)} */}
                    {post.published_at}
                  </li>
                </ul>
                <div className="content mb-16">
                  {/* <MDXRemote {...mdxContent} components={shortcodes} /> */}
                  {post.content}
                </div>
                {config.settings.InnerPaginationOptions.enableBottom && (
                  <InnerPagination posts={posts} date={post.published_at} />
                )}
              </article>
              <div className="mt-16">
                {disqus.enable && (
                  <DiscussionEmbed
                    key={theme}
                    shortname={disqus.shortname}
                    // config={disqusConfig}
                  />
                )}
              </div>
              {/* tags */}
              <div className="flex-inline m-2 p-4">
                {post.tag.length > 0 &&
                  post.tag.map((tag, index) => (
                    <span className="btn btn-info rounded" key={tag.id}>
                      {tag.name}
                    </span>
                  ))}
              </div>
            </div>
            <Sidebar className={"lg:mt-[9.5rem]"} />
          </div>
        </div>

        {/* Related posts */}
        <div className="container mt-20">
          <h2 className="section-title">Related Posts</h2>
          <div className="row mt-16">
            {posts.slice(0, 3).map((post, index) => (
              <div key={post.id} className="mb-12 lg:col-4">
                <Post post={post} />
              </div>
            ))}
          </div>
        </div>
      </section>
    </Base>
  );
};

export default PostSingle;
