import config from "@config/config.json";
import ImageFallback from "@layouts/components/ImageFallback";
import cutStringToWords from "@lib/cutStringToWords";
import dateFormat from "@lib/utils/dateFormat";
import Link from "next/link";
import { FaRegCalendar, FaUserAlt } from "react-icons/fa";

const Post = ({ post }) => {
  const { meta_author } = config.metadata;
  const author = post.user.name ? post.user.name : meta_author;
  return (
    <div className="post">
      <div className="relative">
        {post.image && (
          <ImageFallback
            className="rounded"
            src={post.image}
            alt={post.title}
            width={405}
            height={208}
          />
        )}
        <ul className="absolute left-2 top-3 flex flex-wrap items-center">
          {post.category.map((category, index) => (
            <li
              className="mx-2 inline-flex h-7 rounded-[35px] bg-primary px-3 text-white"
              key={category.id}
            >
              <Link className="capitalize" href={`/categoris/${category.name}`}>
                {category.name}
              </Link>
            </li>
          ))}
        </ul>
      </div>
      <h3 className="h5 mb-2 mt-4">
        <Link
          // href={`/posts/[id]`}
          href={{
            pathname: "/posts/[id]",
            query: { id: post.id },
          }}
          as={`/posts/${post.id}/${encodeURIComponent(post.title)}`}
          className="block hover:text-primary"
        >
          {post.title}
        </Link>
      </h3>
      <ul className="flex items-center space-x-4">
        <li>
          <Link
            className="inline-flex items-center font-secondary text-xs leading-3"
            href="/about"
          >
            <FaUserAlt className="mr-1.5" />
            {author}
          </Link>
        </li>
        <li className="inline-flex items-center font-secondary text-xs leading-3">
          <FaRegCalendar className="mr-1.5" />
          {/* {dateFormat(post.date)} */}
          {post.published_at}
        </li>
      </ul>
      {/* <p>{post.content.slice(0, Number(summary_length))}</p> */}
      <p>
        {cutStringToWords(post.content, 15)}
        <strong className=" text-primary"> . . . </strong>
      </p>
      <Link
        className="btn btn-outline-primary mt-4"
        href={{
          pathname: "/posts/[id]",
          query: { id: post.id },
        }}
        as={`/posts/${post.id}/${encodeURIComponent(post.title)}`}
      >
        Read More
      </Link>
    </div>
  );
};

export default Post;
