package com.example.splashapp;

import android.content.Context;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class LentaAdapter extends RecyclerView.Adapter<LentaAdapter.ViewHolder>  {

    private List<M_Post> Post;
    private List<M_Post> itemsCopy=new ArrayList<M_Post>();
    private Context context;
    private LentaAdapter.ItemClickListener mClickListener;

    public LentaAdapter(Context context,List<M_Post> Post)
    {
        this.Post=Post;
        this.context=context;
        if (Post!=null)
        itemsCopy.addAll(Post);
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int ViewType)
    {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.event_post,parent,false);
        return  new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(LentaAdapter.ViewHolder holder, int position) {
        M_Post or=Post.get(position);
        if (or.getId().equals("13"))
        {
            String st="test";
        }
        holder.id=or.getId();
        holder.title.setText(or.getName());
        holder.name.setText(or.getOrgName());
        holder.date.setText(or.getPostDate());
        holder.about.setText(or.getDescription());
        Picasso.get().load(R.mipmap.about_logo).into(holder.imageView);
        for (int i=0;i<holder.imageViews.length;i++)
        {
                holder.imageViews[i].setVisibility(View.GONE);
        }
        for (int i=0;i<or.getCountImage();i++)
        {
            try {
                Picasso.get().load(or.getImage(i)).into(holder.imageViews[i]);
                holder.imageViews[i].setVisibility(View.VISIBLE);
            }
            catch (Exception e)
            {
               break;
            }
        }
    }

    @Override
    public int getItemCount() {
        return Post.size();
    }

    public void filter(String text) {
        Post.clear();
        if(text.isEmpty()){
            Post.addAll(itemsCopy);
        } else{
            text = text.toLowerCase();
            for(M_Post item: itemsCopy){
                if(item.getName().toLowerCase().contains(text)){
                    Post.add(item);
                }
            }
        }
        notifyDataSetChanged();
    }

    public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public String id;
        public TextView date;
        public TextView about;
        public ImageView imageView;
        public TextView name;
        public TextView title;

        public ImageView [] imageViews=new ImageView[10];



        public ViewHolder (View itemView)
        {
            super(itemView);
            imageView =(ImageView) itemView.findViewById(R.id.imageView12);
            name=(TextView) itemView.findViewById(R.id.textView31);
            date=(TextView) itemView.findViewById(R.id.textView32);
            about=(TextView) itemView.findViewById(R.id.textView18);
            title=(TextView) itemView.findViewById(R.id.titlepost);

            imageViews[0] =(ImageView) itemView.findViewById(R.id.imageView22);
            imageViews[1] =(ImageView) itemView.findViewById(R.id.imageView23);
            imageViews[2] =(ImageView) itemView.findViewById(R.id.imageView24);
            imageViews[3] =(ImageView) itemView.findViewById(R.id.imageView25);
            imageViews[4] =(ImageView) itemView.findViewById(R.id.imageView26);
            imageViews[5] =(ImageView) itemView.findViewById(R.id.imageView27);
            imageViews[6] =(ImageView) itemView.findViewById(R.id.imageView28);
            imageViews[7] =(ImageView) itemView.findViewById(R.id.imageView29);
            imageViews[8] =(ImageView) itemView.findViewById(R.id.imageView30);
            imageViews[9] =(ImageView) itemView.findViewById(R.id.imageView31);

            itemView.setOnClickListener(this);
        }
        @Override
        public void onClick(View view) {
            if (mClickListener != null) mClickListener.onItemClick(view, getAdapterPosition());
        }
    }

    public M_Post getOrg(int id) {
        return Post.get(id);
    }

    public void setClickListener(LentaAdapter.ItemClickListener itemClickListener) {
        this.mClickListener = itemClickListener;
    }

    public interface ItemClickListener {
        void onItemClick(View view, int position);
    }
}
